<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

$table->string('city')->nullable();
$table->string('postal_code')->nullable();

$table->string('card_holder')->nullable();
$table->string('card_number')->nullable();
$table->string('expiry_date')->nullable();
$table->string('cvv')->nullable();

$table->string('mobile_account')->nullable();
$table->string('transaction_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
