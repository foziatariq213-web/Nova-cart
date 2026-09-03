<?php

namespace Tests\Feature;

use Tests\TestCase;

class StripeWebhookTest extends TestCase
{
    public function test_webhook_rejects_request_with_invalid_signature(): void
    {
        config(['services.stripe.webhook_secret' => 'whsec_testsecret']);

        $response = $this->postJson('/stripe/webhook', ['type' => 'payment_intent.succeeded']);

        $response->assertStatus(400);
    }

    public function test_webhook_errors_when_secret_is_not_configured(): void
    {
        config(['services.stripe.webhook_secret' => null]);

        $response = $this->postJson('/stripe/webhook', []);

        $response->assertStatus(500);
    }
}
