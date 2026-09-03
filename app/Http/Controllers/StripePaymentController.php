<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;

class StripePaymentController extends Controller
{
    public function __construct(private StripePaymentService $stripe) {}

    /**
     * Show the Stripe payment page for a card order.
     */
    public function pay(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_method !== 'Credit Card') {
            return redirect()->route('orders.index')
                ->with('error', 'This order does not use card payment.');
        }

        if ($order->payment_status === 'Paid') {
            return redirect()->route('orders.index')
                ->with('success', 'Order #'.$order->order_number.' is already paid.');
        }

        try {
            $intent = $this->stripe->intentForOrder($order);
        } catch (ApiErrorException $e) {
            Log::error('Stripe: could not create PaymentIntent - '.$e->getMessage(), [
                'order_id' => $order->id,
            ]);

            return redirect()->route('orders.index')
                ->with('error', 'Payment could not be started. Please try again in a moment.');
        }

        if ($intent->status === 'succeeded') {
            // Already paid on Stripe's side but the webhook hasn't landed yet — sync now.
            try {
                $this->stripe->record(
                    PaymentIntent::retrieve($intent->id, ['expand' => ['latest_charge']])
                );
            } catch (\Throwable $e) {
                Log::error('Stripe: sync of already-succeeded intent failed - '.$e->getMessage(), [
                    'order_id' => $order->id,
                ]);
            }

            return redirect()->route('orders.index')
                ->with('success', 'Order #'.$order->order_number.' is already paid.');
        }

        return view('frontend.stripe-pay', [
            'order' => $order,
            'clientSecret' => $intent->client_secret,
            'publishableKey' => config('services.stripe.key'),
        ]);
    }

    /**
     * Stripe redirects the customer back here after confirmPayment.
     * The webhook stays the source of truth; this handler verifies the
     * intent server-side (with our secret key) and syncs immediately so
     * the user sees the result even if the webhook is delayed.
     */
    public function handleReturn(Request $request)
    {
        $intentId = $request->query('payment_intent');

        if (! $intentId) {
            Log::warning('Stripe: return page hit without payment_intent param.', [
                'url' => $request->fullUrl(),
            ]);

            return redirect()->route('orders.index')
                ->with('error', 'Could not verify payment — missing payment reference.');
        }

        try {
            $intent = PaymentIntent::retrieve($intentId, ['expand' => ['latest_charge']]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe: return verify failed - '.$e->getMessage(), [
                'intent_id' => $intentId,
                'stripe_error' => $e->getError() ? $e->getError()->toArray() : null,
            ]);

            return redirect()->route('orders.index')
                ->with('error', 'Could not verify payment status. Please check your orders.');
        }

        if ((int) ($intent->metadata['user_id'] ?? 0) !== (int) auth()->id()) {
            Log::warning('Stripe: return page user mismatch.', [
                'intent_id' => $intent->id,
                'intent_user_id' => $intent->metadata['user_id'] ?? null,
                'auth_user_id' => auth()->id(),
            ]);
            abort(403);
        }

        $this->stripe->record($intent);

        $orderNumber = $intent->metadata['order_number'] ?? '';

        return match ($intent->status) {
            'succeeded' => redirect()->route('orders.index')
                ->with('success', 'Payment successful! Order '.$orderNumber.' has been paid.'),
            'processing' => redirect()->route('orders.index')
                ->with('success', 'Payment for order '.$orderNumber.' is processing — the status will update automatically.'),
            default => redirect()->route('checkout.stripe.pay', ['order' => $intent->metadata['order_id']])
                ->with('error', 'Payment was not completed. Please try again.'),
        };
    }
}
