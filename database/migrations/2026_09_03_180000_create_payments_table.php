<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('stripe_payment_intent_id')->unique();
            $table->string('stripe_charge_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10);
            $table->string('status', 50)->default('pending');
            $table->string('card_brand', 30)->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->text('receipt_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
