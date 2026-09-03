<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'total',
        'payment_method',
        'payment_status',
        'stripe_payment_intent_id',
        'order_status',
        'items',
    ];

    protected $casts = [
        'items'      => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Order belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order has many order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Order has many payments (Stripe payment attempts).
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        $status = $this->order_status ?? 'pending';

        return in_array(strtolower($status), ['pending', 'processing', 'shipped'])
               && $this->created_at->diffInDays(now()) < 3;
    }

    /**
     * Tracking Progress
     */
    public function trackingStepIndex(): int
    {
        $status = strtolower($this->order_status ?? 'pending');

        return match ($status) {
            'pending' => 0,
            'processing' => 1,
            'shipped' => 2,
            'delivered' => 3,
            default => 0,
        };
    }

    /**
     * Tracking Stages
     */
    public static function trackingStages(): array
    {
        return [
            [
                'key' => 'Pending',
                'label' => 'Order Confirmed',
                'desc' => 'Your order has been received.',
                'icon' => 'fa-circle-check',
            ],
            [
                'key' => 'Processing',
                'label' => 'Processing',
                'desc' => 'Your order is being prepared.',
                'icon' => 'fa-box-open',
            ],
            [
                'key' => 'Shipped',
                'label' => 'Shipped',
                'desc' => 'Your order is on the way.',
                'icon' => 'fa-truck',
            ],
            [
                'key' => 'Delivered',
                'label' => 'Delivered',
                'desc' => 'Your order has been delivered.',
                'icon' => 'fa-house-circle-check',
            ],
        ];
    }

    /**
     * Get payment status label based on payment method and order status
     */
    public function getPaymentStatusLabel(): string
    {
        if (strtolower($this->order_status ?? '') === 'cancelled') {
            return 'Unpaid';
        }

        if ($this->payment_method === 'Cash on Delivery') {
            return 'Unpaid';
        }

        // Card orders carry a real payment state from Stripe — show it as-is
        // instead of assuming the order is paid.
        if ($this->payment_method === 'Credit Card') {
            return $this->payment_status ?: 'Unpaid';
        }

        return 'Paid';
    }

    /**
     * Get payment badge class
     */
    public function getPaymentBadgeClass(): string
    {
        $status = $this->getPaymentStatusLabel();

        return match ($status) {
            'Paid' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'Unpaid' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
            default => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
        };
    }

    /**
     * Get order status badge class
     */
    public function getStatusBadgeClass(): string
    {
        $status = strtolower($this->order_status ?? 'pending');

        return match ($status) {
            'delivered' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'cancelled' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
            'shipped' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            default => 'bg-white/[0.03] text-gray-300 border-white/10',
        };
    }
}