<?php

namespace App\Http\Controllers;

use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __construct(private StripePaymentService $stripe) {}

    /**
     * Handle Stripe webhook events (server-to-server).
     * This request is authenticated by the Stripe-Signature header — the
     * route is excluded from CSRF verification in bootstrap/app.php.
     */
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        if (! $secret) {
            Log::warning('Stripe webhook: secret not configured.');

            return response('Webhook secret not configured', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook: invalid payload - '.$e->getMessage());

            return response('Invalid payload', Response::HTTP_BAD_REQUEST);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook: signature verification failed - '.$e->getMessage());

            return response('Invalid signature', Response::HTTP_BAD_REQUEST);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
            case 'payment_intent.payment_failed':
                $this->syncPayment((string) $event->data->object->id);
                break;
            default:
                Log::info('Stripe webhook: unhandled event type - '.$event->type);
        }

        return response('Webhook handled', Response::HTTP_OK);
    }

    /**
     * Re-retrieve the intent from Stripe before saving — webhook payloads
     * carry a slim object (latest_charge is only an id), and re-fetching
     * with our secret key guarantees the data is authentic and complete.
     */
    protected function syncPayment(string $intentId): void
    {
        try {
            $intent = PaymentIntent::retrieve($intentId, ['expand' => ['latest_charge']]);
        } catch (\Throwable $e) {
            Log::error('Stripe webhook: PaymentIntent retrieve failed - '.$e->getMessage(), [
                'intent_id' => $intentId,
            ]);

            return;
        }

        $this->stripe->record($intent);
    }
}
