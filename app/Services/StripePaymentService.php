<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create (or reuse) a PaymentIntent for a card order.
     * Reusing the stored intent means refreshing the pay page or retrying
     * a failed card does NOT create duplicate intents on Stripe.
     */
    public function intentForOrder(Order $order): PaymentIntent
    {
        $expectedAmount = (int) round($order->total * 100);

        if ($order->stripe_payment_intent_id) {
            try {
                $intent = PaymentIntent::retrieve($order->stripe_payment_intent_id);

                // Reuse only while it is still payable and the amount matches.
                if ($intent->status !== 'canceled' && $intent->amount === $expectedAmount) {
                    return $intent;
                }
            } catch (ApiErrorException $e) {
                Log::warning('Stripe: stored intent not retrievable, creating a new one.', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $intent = PaymentIntent::create([
            'amount' => $expectedAmount,
            'currency' => config('services.stripe.currency', 'pkr'),
            'automatic_payment_methods' => ['enabled' => true],
            'description' => 'NovaCart Order '.$order->order_number,
            'receipt_email' => $order->email,
            'metadata' => [
                // Stripe metadata only accepts strings
                'order_id' => (string) $order->id,
                'order_number' => $order->order_number,
                'user_id' => (string) $order->user_id,
            ],
        ]);

        $order->update(['stripe_payment_intent_id' => $intent->id]);

        return $intent;
    }

    /**
     * Persist the payment result for an intent and sync the order's
     * payment_status. Idempotent (updateOrCreate on the intent id), so it
     * is safe to call from both the webhook and the return page.
     */
    public function record(PaymentIntent $intent): ?Payment
    {
        $orderId = $intent->metadata['order_id'] ?? null;

        if (! $orderId) {
            Log::error('Stripe: order_id missing in intent metadata, skipping.', [
                'intent_id' => $intent->id,
            ]);

            return null;
        }

        return DB::transaction(function () use ($intent, $orderId) {
            $order = Order::lockForUpdate()->find($orderId);

            if (! $order) {
                Log::error('Stripe: order not found for intent.', [
                    'intent_id' => $intent->id,
                    'order_id' => $orderId,
                ]);

                return null;
            }

            // latest_charge is a full object only when retrieved with
            // expand=latest_charge; inside webhook payloads it is just an id.
            $charge = $intent->latest_charge;
            $isExpanded = $charge !== null && ! is_string($charge);

            $payment = Payment::updateOrCreate(
                ['stripe_payment_intent_id' => $intent->id],
                [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'stripe_charge_id' => $isExpanded ? $charge->id : ($charge ?: null),
                    'amount' => $intent->amount / 100,
                    'currency' => strtoupper($intent->currency),
                    'status' => $intent->status,
                    'card_brand' => $isExpanded ? ($charge->payment_method_details->card->brand ?? null) : null,
                    'card_last4' => $isExpanded ? ($charge->payment_method_details->card->last4 ?? null) : null,
                    'receipt_url' => $isExpanded ? ($charge->receipt_url ?? null) : null,
                    'paid_at' => $intent->status === 'succeeded' ? now() : null,
                ]
            );

            if ($intent->status === 'succeeded' && $order->payment_status !== 'Paid') {
                $order->update(['payment_status' => 'Paid']);
            }

            Log::info('Stripe: payment recorded.', [
                'intent_id' => $intent->id,
                'order_id' => $order->id,
                'status' => $intent->status,
            ]);

            return $payment;
        });
    }
}
