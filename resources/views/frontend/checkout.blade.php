@extends('layouts.app')
@section('content')

@php
    $trackingStep = isset($order) ? match($order->status) {
        'pending' => 0,
        'processing' => 1,
        'shipped' => 2,
        'delivered' => 3,
        default => 0
    } : 0;
@endphp

<style>
.checkout-bg {
    background: radial-gradient(circle at 50% 0%, #161920 0%, #0d0e12 100%);
    min-height: 100vh;
}
.checkout-card {
    background: #141518;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 1.5rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}
.input {
    width: 100%;
    padding: .9rem 1.2rem;
    background: #08090b;
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: .75rem;
    color: #fff;
    outline: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.input:focus {
    border-color: #6366f1;
    background: #0d0e12;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    transform: translateY(-1px);
}
.pl-11 {
    padding-left: 2.75rem !important;
}
.pay-option {
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 1.25rem;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.01);
    transition: all 0.25s ease;
}
.pay-option:hover {
    border-color: rgba(99, 102, 241, 0.4);
    background: rgba(255, 255, 255, 0.02);
}
.pay-option.active {
    border-color: #6366f1;
    background: linear-gradient(145deg, rgba(99, 102, 241, 0.08) 0%, rgba(99, 102, 241, 0.02) 100%);
    box-shadow: 0 4px 20px rgba(99, 102, 241, 0.05);
}
.error-text {
    color: #ef4444;
    font-size: .8rem;
    margin-top: .4rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.gradient-btn {
    background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}
.gradient-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(99, 102, 241, 0.3);
    filter: brightness(1.1);
}
.gradient-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}
.custom-scroll::-webkit-scrollbar {
    width: 6px;
}
.custom-scroll::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.02);
}
.custom-scroll::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
[x-cloak] { display: none !important; }
/* ---------- Receipt (clean, high-contrast, print-safe) ---------- */
.receipt-shell {
    background: #121317;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 1.5rem;
    box-shadow: 0 25px 60px rgba(0,0,0,0.55);
}
.receipt-topbar {
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #8b5cf6, #22d3ee);
}
.receipt-glow {
    position: absolute;
    width: 220px;
    height: 220px;
    filter: blur(70px);
    opacity: 0.12;
    pointer-events: none;
    border-radius: 999px;
}
.receipt-action-btn {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    color: #cbd5e1;
    transition: all .2s ease;
}
.receipt-action-btn:hover {
    background: rgba(255,255,255,0.07);
    color: #fff;
    border-color: rgba(255,255,255,0.15);
}
.stamp {
    font-family: 'Courier New', monospace;
    font-weight: 900;
    letter-spacing: 0.15em;
    border: 3px solid currentColor;
    border-radius: .5rem;
    padding: .35rem .9rem;
    transform: rotate(-8deg);
    opacity: 0.9;
}
.receipt-cta {
    background: rgba(99, 102, 241, 0.08);
    border: 1px solid rgba(99, 102, 241, 0.3);
    color: #a5b4fc;
    transition: all .25s ease;
}
.receipt-cta:hover {
    background: rgba(99, 102, 241, 0.16);
    border-color: rgba(99, 102, 241, 0.55);
    color: #c7d2fe;
    box-shadow: 0 8px 22px rgba(99, 102, 241, 0.2);
    transform: translateY(-2px);
}
.receipt-cta .icon-box {
    background: rgba(99, 102, 241, 0.15);
    transition: all .25s ease;
}
.receipt-cta:hover .icon-box {
    background: rgba(99, 102, 241, 0.3);
    transform: scale(1.08);
}
.track-cta {
    background: rgba(34, 211, 238, 0.08);
    border: 1px solid rgba(34, 211, 238, 0.3);
    color: #67e8f9;
    transition: all .25s ease;
}
.track-cta:hover {
    background: rgba(34, 211, 238, 0.16);
    border-color: rgba(34, 211, 238, 0.55);
    color: #a5f3fc;
    box-shadow: 0 8px 22px rgba(34, 211, 238, 0.18);
    transform: translateY(-2px);
}
.track-line-bg {
    background: rgba(255,255,255,0.08);
}
.track-line-fill {
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #22d3ee);
    transition: width 0.8s ease-in-out;
}
.track-node {
    width: 2.75rem;
    height: 2.75rem;
    border-radius: 999px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255,255,255,0.1);
    background: #0c0d10;
    color: #6b7280;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 10;
}
.track-node.done {
    border-color: #6366f1;
    background: linear-gradient(145deg, #6366f1, #4f46e5);
    color: #fff;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
}
.track-node.current {
    animation: pulse-node 1.6s ease-in-out infinite;
}
@keyframes pulse-node {
    0%, 100% { box-shadow: 0 0 0 0 rgba(34, 211, 238, 0.35); }
    50% { box-shadow: 0 0 0 8px rgba(34, 211, 238, 0); }
}
</style>

<div class="checkout-bg py-16" x-data="{
    payment: 'Cash on Delivery',
    isSubmitting: false,
    orderSuccess: false,
    showReceipt: false,
    showTracking: false,
    orderNumber: 'ORD-' + Math.floor(100000 + Math.random() * 900000),
    orderDate: new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }),
    trackingStep: {{ $trackingStep }},
    trackingStages: [
        { label: 'Order Confirmed', desc: 'Your order has been received', icon: 'fa-circle-check' },
        { label: 'Processing', desc: 'Preparing your items for shipment', icon: 'fa-box-open' },
        { label: 'Dispatched', desc: 'Your parcel has left the warehouse', icon: 'fa-truck-fast' },
        { label: 'Delivered', desc: 'Package handed over to you', icon: 'fa-house-circle-check' },
    ],
    form: { name: '', phone: '', address: '', city: '', postal_code: '' },

    async submitForm() {
        const form = document.getElementById('checkoutForm');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        this.isSubmitting = true;

        this.form.name = document.getElementsByName('name')[0].value;
        this.form.phone = document.getElementsByName('phone')[0].value;
        this.form.address = document.getElementsByName('address')[0].value;
        this.form.city = document.getElementsByName('city')[0].value;
        this.form.postal_code = document.getElementsByName('postal_code')[0].value;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            });

            const data = await response.json();

            if (response.ok && data.success) {
                this.orderSuccess = true;
                this.orderNumber = data.order_number;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                alert(data.message ?? 'Order could not be placed.');
            }
        } catch (error) {
            alert('Something went wrong.');
            console.error(error);
        } finally {
            this.isSubmitting = false;
        }
    }
}">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- STANDARD CHECKOUT SCREEN --}}
        <div x-show="!orderSuccess" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0">

            {{-- PAGE HEADER --}}
            <div class="mb-12 text-left backdrop-blur-sm p-2 rounded-xl inline-block">
                <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight flex items-center gap-3">
                    <i class="fa-solid fa-bag-shopping text-indigo-500 text-3xl sm:text-4xl"></i> Secure Checkout
                </h1>
                <p class="text-gray-400 mt-2 text-sm sm:text-base">Please review your items and input correct dispatch information.</p>
            </div>

            @if(count($cartItems) == 0)
                <div class="checkout-card py-24 px-6 text-center max-w-2xl mx-auto border border-dashed border-white/10">
                    <div class="w-24 h-24 bg-indigo-500/10 rounded-full flex items-center justify-between mx-auto mb-6">
                        <i class="fa-solid fa-cart-arrow-down text-4xl text-indigo-400 mx-auto"></i>
                    </div>
                    <h2 class="text-3xl text-white font-black">Your basket is feeling light!</h2>
                    <p class="text-gray-400 mt-3 max-w-sm mx-auto">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('shop') }}" class="gradient-btn inline-flex items-center gap-2 mt-8 px-8 py-3.5 rounded-xl text-white font-bold tracking-wide">
                        <i class="fa-solid fa-shop text-sm"></i> Explore Shop
                    </a>
                </div>
            @else
                <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm" @submit.prevent="submitForm()">
                    @csrf
                    <div class="grid lg:grid-cols-12 gap-8 items-start">

                        {{-- LEFT COLUMN: BILLING & PAYMENTS --}}
                        <div class="lg:col-span-7 space-y-6">

                            {{-- BILLING CARD --}}
                            <div class="checkout-card p-6 sm:p-8 space-y-6">
                                <div class="flex items-center justify-between border-b border-white/5 pb-4 mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                                            <i class="fa-solid fa-truck-fast text-indigo-400 text-sm"></i>
                                        </div>
                                        <h2 class="text-white text-lg font-bold tracking-wide">Shipping & Billing Address</h2>
                                    </div>
                                </div>

                                {{-- FULL NAME --}}
                                <div class="space-y-1.5">
                                    <label class="text-gray-400 text-xs uppercase font-semibold tracking-wider flex items-center gap-1.5">
                                        Full Name <span class="text-indigo-400">*</span>
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-indigo-400 transition-colors">
                                            <i class="fa-regular fa-user text-sm"></i>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name') }}" class="input pl-11" required placeholder="e.g. Muhammad Ali">
                                    </div>
                                    @error('name') <p class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>

                                {{-- PHONE NUMBER --}}
                                <div class="space-y-1.5">
                                    <label class="text-gray-400 text-xs uppercase font-semibold tracking-wider flex items-center gap-1.5">
                                        Phone Number <span class="text-indigo-400">*</span>
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-indigo-400 transition-colors">
                                            <i class="fa-solid fa-phone text-xs"></i>
                                        </div>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" class="input pl-11" required placeholder="e.g. 03001234567">
                                    </div>
                                    @error('phone') <p class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>

                                {{-- STREET ADDRESS --}}
                                <div class="space-y-1.5">
                                    <label class="text-gray-400 text-xs uppercase font-semibold tracking-wider flex items-center gap-1.5">
                                        Street Address <span class="text-indigo-400">*</span>
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-indigo-400 transition-colors">
                                            <i class="fa-solid fa-location-dot text-sm"></i>
                                        </div>
                                        <input type="text" name="address" value="{{ old('address') }}" class="input pl-11" required placeholder="House number, Street name, Apartment">
                                    </div>
                                    @error('address') <p class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>

                                {{-- CITY & POSTAL CODE --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="text-gray-400 text-xs uppercase font-semibold tracking-wider flex items-center gap-1.5">
                                            City <span class="text-indigo-400">*</span>
                                        </label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-indigo-400 transition-colors">
                                                <i class="fa-solid fa-city text-xs"></i>
                                            </div>
                                            <input type="text" name="city" value="{{ old('city') }}" class="input pl-11" required placeholder="e.g. Lahore">
                                        </div>
                                        @error('city') <p class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-gray-400 text-xs uppercase font-semibold tracking-wider flex items-center gap-1.5">
                                            Postal Code <span class="text-indigo-400">*</span>
                                        </label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-indigo-400 transition-colors">
                                                <i class="fa-regular fa-envelope text-sm"></i>
                                            </div>
                                            <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="input pl-11" required placeholder="e.g. 54000">
                                        </div>
                                        @error('postal_code') <p class="error-text"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- PAYMENT GATEWAY CARD --}}
                            <div class="checkout-card p-6 sm:p-8">
                                <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-5">
                                    <i class="fa-solid fa-shield-halved text-indigo-400 text-xl"></i>
                                    <h3 class="text-white text-xl font-bold tracking-wide">Secure Payment Gateway</h3>
                                </div>
                                <div class="space-y-3.5">
                                    {{-- COD --}}
                                    <label class="pay-option flex items-center justify-between p-4" :class="payment == 'Cash on Delivery' ? 'active' : ''">
                                        <div class="flex items-center gap-4">
                                            <input type="radio" name="payment_method" value="Cash on Delivery" x-model="payment" class="w-4 h-4 text-indigo-600 bg-black border-white/10 focus:ring-indigo-500">
                                            <div>
                                                <p class="text-white font-bold text-sm sm:text-base">Cash on Delivery (COD)</p>
                                                <p class="text-gray-400 text-xs sm:text-sm mt-0.5">Pay with liquid cash upon shipment dropoff</p>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center">
                                            <i class="fa-solid fa-hand-holding-dollar text-green-400 text-lg"></i>
                                        </div>
                                    </label>

                                    {{-- CARD --}}
                                    <label class="pay-option flex items-center justify-between p-4" :class="payment == 'Credit Card' ? 'active' : ''">
                                        <div class="flex items-center gap-4">
                                            <input type="radio" name="payment_method" value="Credit Card" x-model="payment" class="w-4 h-4 text-indigo-600 bg-black border-white/10 focus:ring-indigo-500">
                                            <div>
                                                <p class="text-white font-bold text-sm sm:text-base">Credit / Debit Card</p>
                                                <p class="text-gray-400 text-xs sm:text-sm mt-0.5">Secure payment processing via Visa / MasterCard</p>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center">
                                            <i class="fa-solid fa-credit-card text-indigo-400 text-lg"></i>
                                        </div>
                                    </label>

                                    {{-- CARD DYNAMIC INPUTS --}}
                                    <div x-show="payment == 'Credit Card'" x-transition x-cloak class="mt-2 space-y-4 bg-black/30 p-5 rounded-2xl border border-white/5">
                                        <div>
                                            <label class="text-gray-400 text-xs uppercase font-semibold">Cardholder Name</label>
                                            <input type="text" name="card_name" class="input mt-1.5">
                                        </div>
                                        <div>
                                            <label class="text-gray-400 text-xs uppercase font-semibold">Card Number</label>
                                            <input type="text" name="card_number" class="input mt-1.5" maxlength="19">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-gray-400 text-xs uppercase font-semibold">Expiry Date</label>
                                                <input type="text" name="card_expiry" class="input mt-1.5" placeholder="MM/YY">
                                            </div>
                                            <div>
                                                <label class="text-gray-400 text-xs uppercase font-semibold">CVC / CVV</label>
                                                <input type="password" name="card_cvv" class="input mt-1.5" maxlength="4">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- JAZZCASH --}}
                                    <label class="pay-option flex items-center justify-between p-4" :class="payment == 'JazzCash' ? 'active' : ''">
                                        <div class="flex items-center gap-4">
                                            <input type="radio" name="payment_method" value="JazzCash" x-model="payment" class="w-4 h-4 text-indigo-600 bg-black border-white/10 focus:ring-indigo-500">
                                            <div>
                                                <p class="text-white font-bold text-sm sm:text-base">JazzCash Mobile Wallet</p>
                                                <p class="text-gray-400 text-xs sm:text-sm mt-0.5">Pay via instant routing to your mobile wallet app</p>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center">
                                            <i class="fa-solid fa-mobile-screen-button text-orange-400 text-lg"></i>
                                        </div>
                                    </label>
                                    <div x-show="payment == 'JazzCash'" x-transition x-cloak class="mt-2 bg-black/30 p-5 rounded-2xl border border-white/5">
                                        <label class="text-gray-400 text-xs uppercase font-semibold">JazzCash Registered Mobile Number</label>
                                        <input type="text" name="jazzcash_number" class="input mt-1.5" placeholder="03XXXXXXXXX">
                                    </div>

                                    {{-- EASYPAISA --}}
                                    <label class="pay-option flex items-center justify-between p-4" :class="payment == 'EasyPaisa' ? 'active' : ''">
                                        <div class="flex items-center gap-4">
                                            <input type="radio" name="payment_method" value="EasyPaisa" x-model="payment" class="w-4 h-4 text-indigo-600 bg-black border-white/10 focus:ring-indigo-500">
                                            <div>
                                                <p class="text-white font-bold text-sm sm:text-base">EasyPaisa Digital Wallet</p>
                                                <p class="text-gray-400 text-xs sm:text-sm mt-0.5">Pay via instant routing to your mobile wallet app</p>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                                            <i class="fa-solid fa-wallet text-emerald-400 text-lg"></i>
                                        </div>
                                    </label>
                                    <div x-show="payment == 'EasyPaisa'" x-transition x-cloak class="mt-2 bg-black/30 p-5 rounded-2xl border border-white/5">
                                        <label class="text-gray-400 text-xs uppercase font-semibold">EasyPaisa Registered Mobile Number</label>
                                        <input type="text" name="easypaisa_number" class="input mt-1.5" placeholder="03XXXXXXXXX">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT COLUMN: ORDER SUMMARY --}}
                        <div class="lg:col-span-5">
                            <div class="checkout-card p-6 sm:p-8 sticky top-10 border border-indigo-500/10">
                                <h2 class="text-white text-2xl font-black mb-6 tracking-wide flex items-center justify-between">
                                    <span>Order Summary</span>
                                    <span class="text-xs bg-indigo-500/10 text-indigo-400 px-3 py-1 rounded-full border border-indigo-500/20">
                                        {{ count($cartItems) }} {{ count($cartItems) > 1 ? 'Items' : 'Item' }}
                                    </span>
                                </h2>
                                <div class="space-y-4 max-h-72 overflow-y-auto pr-2 custom-scroll border-b border-white/5 pb-5">
                                    @foreach($cartItems as $item)
                                        <div class="flex items-center justify-between gap-4 p-2 rounded-xl hover:bg-white/[0.01] transition duration-200">
                                            <div class="flex-1">
                                                <h4 class="text-white font-semibold text-sm sm:text-base truncate max-w-[200px]">{{ $item['name'] }}</h4>
                                                <p class="text-gray-400 text-xs mt-0.5">Quantity: <span class="text-indigo-400 font-medium">{{ $item['quantity'] }}</span></p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-white font-bold text-sm">Rs {{ number_format($item['new_price'] * $item['quantity']) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-6 space-y-3.5">
                                    <div class="flex justify-between text-sm text-gray-400">
                                        <span>Subtotal</span>
                                        <span class="text-white font-medium">Rs {{ number_format($subtotal) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-400">
                                        <span>Estimated Shipping</span>
                                        <span class="text-emerald-400 font-semibold uppercase tracking-wider text-xs bg-emerald-500/10 px-2 py-0.5 rounded-md border border-emerald-500/10">Free</span>
                                    </div>
                                    <div class="flex justify-between text-white text-2xl font-black pt-4 border-t border-white/10 mt-2">
                                        <span>Total Due</span>
                                        <span class="text-indigo-400">Rs {{ number_format($subtotal) }}</span>
                                    </div>
                                </div>
                                <button type="submit" :disabled="isSubmitting" class="w-full gradient-btn mt-8 py-4 rounded-xl text-white font-bold shadow-lg tracking-wider text-sm sm:text-base flex items-center justify-center gap-2.5">
                                    <template x-if="!isSubmitting">
                                        <span class="flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-lock text-xs"></i> Place Order Now
                                        </span>
                                    </template>
                                    <template x-if="isSubmitting">
                                        <span class="flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-circle-notch fa-spin text-sm"></i> Registering Order...
                                        </span>
                                    </template>
                                </button>
                                <a href="{{ route('cart') }}" class="flex items-center justify-center gap-2 mt-5 text-center text-sm text-gray-400 hover:text-white transition duration-200 group">
                                    <i class="fa-solid fa-arrow-left text-xs transform group-hover:-translate-x-1 transition-transform"></i> Back To Shopping Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>

        {{-- ORDER SUCCESS SCREEN --}}
        <div x-show="orderSuccess && !showReceipt && !showTracking" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" class="max-w-2xl mx-auto text-center py-12">
            <div class="checkout-card p-8 sm:p-12 space-y-6 relative overflow-hidden border border-indigo-500/10">
                <div class="w-24 h-24 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fa-solid fa-circle-check text-5xl text-emerald-400"></i>
                </div>
                <div class="space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-widest px-3 py-1 rounded-full border"
                          :class="payment == 'Cash on Delivery' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'">
                        <span x-text="payment == 'Cash on Delivery' ? 'Order Confirmed (COD)' : 'Payment Authorized'"></span>
                    </span>
                    <h2 class="text-3xl sm:text-4xl text-white font-black tracking-tight mt-3">Your Order is Placed!</h2>
                    <p class="text-gray-400 text-sm sm:text-base max-w-md mx-auto">
                        <span x-text="payment == 'Cash on Delivery' ? 'Your package is now in transit under Cash on Delivery (COD) terms' : 'Your mock transaction completed. We are configuring your premium dispatch parcel now.'"></span>
                    </p>
                </div>
                <div class="bg-black/40 border border-white/5 rounded-2xl p-5 grid grid-cols-2 gap-4 text-left divide-x divide-white/5">
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-semibold">Order Reference</p>
                        <p class="text-indigo-400 font-mono font-bold mt-1 text-sm sm:text-base" x-text="orderNumber"></p>
                    </div>
                    <div class="pl-4">
                        <p class="text-gray-500 text-xs uppercase font-semibold" x-text="payment == 'Cash on Delivery' ? 'Balance on Delivery' : 'Amount Processed'"></p>
                        <p class="text-emerald-400 font-bold mt-1 text-sm sm:text-base">Rs {{ number_format($subtotal) }}</p>
                    </div>
                </div>
                <div class="pt-2 text-left space-y-3">
                    <p class="text-white text-xs uppercase font-bold tracking-wider text-center sm:text-left">What Happens Next?</p>
                    <div class="grid grid-cols-3 gap-2 text-center text-[11px] sm:text-xs">
                        <div class="p-3 bg-white/[0.02] border border-white/5 rounded-xl">
                            <i class="fa-solid fa-box text-indigo-400 mb-1.5 block text-base"></i>
                            <span class="text-white font-medium block">Verified</span>
                            <span class="text-gray-500 text-[10px]">Just now</span>
                        </div>
                        <div class="p-3 bg-white/[0.01] border border-white/5 rounded-xl opacity-60">
                            <i class="fa-solid fa-dolly text-gray-400 mb-1.5 block text-base"></i>
                            <span class="text-gray-400 block">Processing</span>
                            <span class="text-gray-600 text-[10px]">Within 24h</span>
                        </div>
                        <div class="p-3 bg-white/[0.01] border border-white/5 rounded-xl opacity-60">
                            <i class="fa-solid fa-truck-ramp-box text-gray-400 mb-1.5 block text-base"></i>
                            <span class="text-gray-400 block">Dispatched</span>
                            <span class="text-gray-600 text-[10px]">2-3 Days</span>
                        </div>
                    </div>
                </div>
                <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('shop') }}" class="gradient-btn px-6 py-3.5 rounded-xl text-white font-bold text-sm tracking-wide shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
                    </a>
                    <button @click="showReceipt = true; showTracking = false;" class="receipt-cta px-6 py-3.5 rounded-xl text-sm font-bold transition flex items-center justify-center gap-2.5">
                        <span class="icon-box w-7 h-7 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-receipt text-xs"></i>
                        </span>
                        View Invoice Receipt
                    </button>
                    <button @click="showTracking = true; showReceipt = false;" class="track-cta px-6 py-3.5 rounded-xl text-sm font-bold transition flex items-center justify-center gap-2.5">
                        <i class="fa-solid fa-truck-fast"></i> Track My Order
                    </button>
                </div>
            </div>
        </div>

        {{-- PREMIUM INVOICE RECEIPT --}}
        <div x-show="showReceipt" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 scale-95 translate-y-6" class="max-w-2xl mx-auto py-6 print:py-0">
            <div class="receipt-shell relative overflow-hidden print:shadow-none print:border-0">
                <div class="receipt-topbar"></div>
                <div class="receipt-glow bg-indigo-500 -top-16 -left-16"></div>
                <div class="receipt-glow bg-cyan-400 -bottom-16 -right-16"></div>
                <div class="relative p-6 sm:p-10">
                    <div class="flex justify-between items-start border-b border-white/[0.08] pb-6 mb-6 print:hidden">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                                <i class="fa-solid fa-receipt text-white text-base"></i>
                            </div>
                            <div>
                                <h3 class="text-white text-lg sm:text-xl font-black tracking-wide">NovaCart Invoice</h3>
                                <p class="text-[11px] text-gray-500 font-mono tracking-wide mt-0.5" x-text="'Ref: ' + orderNumber + ' · ' + orderDate"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="window.print()" class="receipt-action-btn p-2.5 rounded-xl text-xs flex items-center gap-1.5 font-medium">
                                <i class="fa-solid fa-print"></i> <span class="hidden sm:inline">Print</span>
                            </button>
                            <button @click="showReceipt = false" class="receipt-action-btn p-2.5 rounded-full">
                                <i class="fa-solid fa-xmark text-sm w-4 h-4 flex items-center justify-center"></i>
                            </button>
                        </div>
                    </div>
                    <div class="hidden print:block mb-6">
                        <h3 class="text-black text-2xl font-black">NovaCart Invoice</h3>
                        <p class="text-sm text-gray-600" x-text="'Ref: ' + orderNumber + ' · ' + orderDate"></p>
                    </div>
                    <div class="absolute top-24 right-8 hidden sm:block print:hidden"
                         :class="payment == 'Cash on Delivery' ? 'text-amber-400' : 'text-emerald-400'">
                        <div class="stamp text-xs" x-text="payment == 'Cash on Delivery' ? 'COD PENDING' : 'PAID'"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 bg-black/30 border border-white/[0.06] p-5 rounded-2xl mb-6">
                        <div class="space-y-1">
                            <p class="text-[10px] uppercase font-bold tracking-wider text-indigo-400">Ship To</p>
                            <p class="text-white font-bold text-sm" x-text="form.name"></p>
                            <p class="text-gray-300 text-xs leading-relaxed" x-text="form.address"></p>
                            <p class="text-gray-300 text-xs" x-text="form.city + ' — ' + form.postal_code"></p>
                            <p class="text-gray-400 text-xs mt-1" x-text="'Phone: ' + form.phone"></p>
                        </div>
                        <div class="space-y-2 sm:text-right border-t sm:border-t-0 sm:border-l border-white/[0.08] pt-3 sm:pt-0 sm:pl-5">
                            <div>
                                <p class="text-[10px] uppercase font-bold tracking-wider text-cyan-400">Payment Method</p>
                                <p class="text-white text-sm font-semibold mt-0.5" x-text="payment"></p>
                            </div>
                            <div class="inline-flex sm:justify-end">
                                <span class="px-3 py-1 rounded-lg text-[11px] font-bold tracking-wide uppercase border flex items-center gap-1.5"
                                      :class="payment == 'Cash on Delivery' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'">
                                    <i class="fa-solid" :class="payment == 'Cash on Delivery' ? 'fa-clock-rotate-left' : 'fa-circle-check'"></i>
                                    <span x-text="payment == 'Cash on Delivery' ? 'Collection Pending' : 'Payment Confirmed'"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <p class="text-[11px] uppercase font-black tracking-wider text-gray-400">Order Items</p>
                        <div class="border border-white/[0.08] rounded-2xl overflow-hidden">
                            <table class="w-full text-left text-sm text-gray-200">
                                <thead class="bg-white/[0.03] text-gray-400 font-bold uppercase text-[10px] tracking-wider border-b border-white/[0.08]">
                                    <tr>
                                        <th class="p-4">Item</th>
                                        <th class="p-4 text-center w-20">quantity</th>
                                        <th class="p-4 text-right w-32">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/[0.06]">
                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td class="p-4 font-semibold text-white truncate max-w-[240px]">{{ $item['name'] }}</td>
                                        <td class="p-4 text-center">
                                            <span class="bg-white/[0.06] text-indigo-300 font-mono font-bold px-2.5 py-1 rounded-md border border-white/10 text-xs">
                                                {{ $item['quantity'] }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-right font-mono font-bold text-gray-100">Rs {{ number_format($item['new_price'] * $item['quantity']) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="border-t border-white/[0.08] mt-6 pt-5 space-y-3 text-sm text-gray-300">
                        <div class="flex justify-between items-center">
                            <span>Subtotal</span>
                            <span class="text-white font-mono font-semibold">Rs {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Shipping</span>
                            <span class="text-emerald-400 font-bold text-[10px] bg-emerald-500/10 px-2.5 py-0.5 rounded-md border border-emerald-500/20 tracking-wider uppercase">Free</span>
                        </div>
                        <div class="border-t border-dashed border-white/15 my-1"></div>
                        <div class="flex justify-between items-center pt-1">
                            <p class="text-white text-base font-black" x-text="payment == 'Cash on Delivery' ? 'Cash to Pay on Delivery' : 'Total Paid'"></p>
                            <span class="text-2xl font-black text-indigo-300 font-mono">Rs {{ number_format($subtotal) }}</span>
                        </div>
                    </div>
                    <div class="mt-8 pt-5 border-t border-white/[0.08] text-center space-y-3 print:hidden">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/[0.03] border border-white/[0.08] rounded-full text-[10px] text-gray-400 font-mono mx-auto">
                            <i class="fa-solid fa-shield-check text-indigo-400"></i> Secured by NovaCart Trust Engine
                        </div>
                        <button @click="showReceipt = false" class="text-xs text-indigo-400 hover:text-indigo-300 font-bold tracking-wider transition uppercase hover:underline flex items-center gap-1.5 mx-auto pt-2">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ORDER TRACKING PANEL --}}
        <div x-show="showTracking" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 scale-95 translate-y-6" class="max-w-2xl mx-auto py-6">
            <div class="receipt-shell relative overflow-hidden">
                <div class="receipt-topbar"></div>
                <div class="p-6 sm:p-10">
                    <div class="flex justify-between items-start border-b border-white/[0.08] pb-6 mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-cyan-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                                <i class="fa-solid fa-truck-fast text-white text-base"></i>
                            </div>
                            <div>
                                <h3 class="text-white text-lg sm:text-xl font-black tracking-wide">Track Your Order</h3>
                                <p class="text-[11px] text-gray-500 font-mono tracking-wide mt-0.5" x-text="'Ref: ' + orderNumber"></p>
                            </div>
                        </div>
                        <button @click="showTracking = false" class="receipt-action-btn p-2.5 rounded-full">
                            <i class="fa-solid fa-xmark text-sm w-4 h-4 flex items-center justify-center"></i>
                        </button>
                    </div>
                    <div class="relative px-2 mb-10">
                        <div class="absolute top-[22px] left-6 right-6 h-1 track-line-bg rounded-full"></div>
                        <div class="absolute top-[22px] left-6 h-1 track-line-fill rounded-full"
                             :style="'width: calc(' + (trackingStep / (trackingStages.length - 1) * 100) + '% - ' + (trackingStep / (trackingStages.length - 1) * 48) + 'px)'"></div>
                        <div class="relative flex justify-between">
                            <template x-for="(stage, index) in trackingStages" :key="index">
                                <div class="flex flex-col items-center gap-2 w-1/4">
                                    <div class="track-node" :class="index < trackingStep ? 'done' : (index === trackingStep ? 'done current' : '')">
                                        <i class="fa-solid text-sm" :class="stage.icon"></i>
                                    </div>
                                    <p class="text-[11px] font-bold text-center leading-tight mt-2" :class="index <= trackingStep ? 'text-white' : 'text-gray-500'" x-text="stage.label"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="bg-black/30 border border-white/[0.06] rounded-2xl p-5 mb-6">
                        <p class="text-[10px] uppercase font-bold tracking-wider text-cyan-400 mb-1">Current Status</p>
                        <p class="text-white font-bold text-base" x-text="trackingStages[trackingStep].label"></p>
                        <p class="text-gray-400 text-sm mt-1" x-text="trackingStages[trackingStep].desc"></p>
                        <p class="text-gray-500 text-xs mt-3 flex items-center gap-1.5" x-show="trackingStep < trackingStages.length - 1">
                          
                        </p>
                        <p class="text-emerald-400 text-xs mt-3 flex items-center gap-1.5 font-semibold" x-show="trackingStep === trackingStages.length - 1">
                            <i class="fa-solid fa-circle-check"></i> Your parcel has been delivered successfully.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-xs mb-8">
                        <div class="bg-white/[0.02] border border-white/5 rounded-xl p-4">
                            <p class="text-gray-500 uppercase font-semibold text-[10px] mb-1">Deliver To</p>
                            <p class="text-white font-medium" x-text="form.city || 'Your address'"></p>
                        </div>
                        <div class="bg-white/[0.02] border border-white/5 rounded-xl p-4">
                            <p class="text-gray-500 uppercase font-semibold text-[10px] mb-1">Payment</p>
                            <p class="text-white font-medium" x-text="payment"></p>
                        </div>
                    </div>
                    <div class="text-center pt-2 border-t border-white/[0.08]">
                        <button @click="showTracking = false" class="text-xs text-cyan-400 hover:text-cyan-300 font-bold tracking-wider transition uppercase hover:underline flex items-center gap-1.5 mx-auto">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
