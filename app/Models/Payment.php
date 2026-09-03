<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'amount',
        'currency',
        'status',
        'card_brand',
        'card_last4',
        'receipt_url',
        'paid_at',
    ];

    protected $hidden = [
        'stripe_payment_intent_id',
        'stripe_charge_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Each payment belongs to one order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Each payment belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
