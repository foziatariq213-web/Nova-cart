<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show Checkout Page
     */
    public function index()
    {
        $cartItems = session('cart', []);

        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['new_price'] * $item['quantity'];  // 🔥 'qty' ki jagah 'quantity'
        });

        return view('checkout', compact('cartItems', 'subtotal'));
    }

    /**
     * Store Order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'payment_method' => 'required|string',
        ]);

        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.view')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['new_price'] * $item['quantity'];  // 🔥 'qty' ki jagah 'quantity'
        });

        // Create Order
        $order = Order::create([
            'user_id'        => auth()->id(),
            'order_number'   => 'ORD-' . strtoupper(Str::random(8)),
            'customer_name'  => $validated['name'],
            'email'          => auth()->check() ? auth()->user()->email : null,
            'phone'          => $validated['phone'],
            'address'        => $validated['address'],
            'city'           => $validated['city'],
            'postal_code'    => $validated['postal_code'],
            'total'          => $subtotal,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_method'] === 'Cash on Delivery'
                                    ? 'Unpaid'
                                    : 'Paid',
            'order_status'   => 'Pending',
        ]);

        // Save Order Items
        foreach ($cartItems as $productId => $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['product_id'] ?? null,  // 🔥 product_id se lein
                'product_name' => $item['name'],
                'quantity'     => $item['quantity'],  // 🔥 'qty' ki jagah 'quantity'
                'price'        => $item['new_price'],
                'subtotal'     => $item['new_price'] * $item['quantity'],  // 🔥 'qty' ki jagah 'quantity'
            ]);
        }

        // Clear Cart
        session()->forget('cart');

        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Order Success Page
     */
    public function success($orderNumber)
    {
        $order = Order::with('items')
                    ->where('order_number', $orderNumber)
                    ->firstOrFail();

        return view('checkout-success', compact('order'));
    }

    /**
     * Track Order Status
     */
    public function trackStatus($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                    ->firstOrFail();

        return response()->json([
            'order_status'   => $order->order_status,
            'payment_status' => $order->payment_status,
            'step'           => $order->trackingStepIndex(),
            'updated_human'  => $order->updated_at->diffForHumans(),
        ]);
    }
}