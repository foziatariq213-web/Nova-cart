@extends('layouts.app')
@section('content')

@php
    // Get order status
    $orderStatus = $order->order_status ?? $order->status ?? 'pending';
    $orderStatusLower = strtolower($orderStatus);
    
    // Tracking step
    $trackingStep = match($orderStatusLower) {
        'pending' => 0,
        'processing' => 1,
        'shipped' => 2,
        'delivered' => 3,
        default => 0
    };
    
    // Decode items safely
    $items = [];
    if (!empty($order->items)) {
        if (is_string($order->items)) {
            $items = json_decode($order->items, true) ?? [];
        } elseif (is_array($order->items)) {
            $items = $order->items;
        }
    }
    $itemCount = count($items);
    
    // Payment Status Logic
    if($orderStatusLower === 'cancelled') {
        $paymentStatus = 'Unpaid';
        $paymentBadgeClass = 'bg-rose-500/10 text-rose-400 border-rose-500/20';
        $paymentIcon = 'fa-circle-xmark';
    } 
    elseif($order->payment_method === 'Cash on Delivery') {
        if($orderStatusLower === 'delivered') {
            $paymentStatus = 'Paid';
            $paymentBadgeClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
            $paymentIcon = 'fa-circle-check';
        } else {
            $paymentStatus = 'Pending';
            $paymentBadgeClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
            $paymentIcon = 'fa-clock';
        }
    }
    elseif($order->payment_method === 'Credit Card') {
        // Card orders ka asli status Stripe se aata hai (webhook DB update
        // karta hai) — yahan guess nahi, DB wala payment_status dikhao.
        if($order->payment_status === 'Paid') {
            $paymentStatus = 'Paid';
            $paymentBadgeClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
            $paymentIcon = 'fa-circle-check';
        } else {
            $paymentStatus = 'Unpaid';
            $paymentBadgeClass = 'bg-rose-500/10 text-rose-400 border-rose-500/20';
            $paymentIcon = 'fa-circle-xmark';
        }
    }
    else {
        $paymentStatus = 'Paid';
        $paymentBadgeClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
        $paymentIcon = 'fa-circle-check';
    }
    
    // Order Status Badge
    $statusBadgeClass = match($orderStatusLower) {
        'delivered' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
        'cancelled' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
        'shipped' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
        'processing' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
        default => 'bg-white/[0.03] text-gray-300 border-white/10',
    };
    
    $statusIcon = match($orderStatusLower) {
        'delivered' => 'fa-circle-check',
        'cancelled' => 'fa-circle-xmark',
        'shipped' => 'fa-truck',
        'processing' => 'fa-spinner',
        default => 'fa-clock',
    };
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
.summary-item {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 1rem;
    transition: all 0.3s ease;
}
.summary-item:hover {
    background: rgba(255,255,255,0.04);
    border-color: rgba(99, 102, 241, 0.2);
    transform: translateX(4px);
}
.status-badge {
    padding: 0.35rem 1rem;
    border-radius: 999px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
</style>

<div class="checkout-bg py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- PAGE HEADER --}}
        <div class="mb-10 text-left">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight flex items-center gap-3">
                        <i class="fa-solid fa-receipt text-indigo-500 text-3xl sm:text-4xl"></i> Order Details
                    </h1>
                    <p class="text-gray-400 mt-2 text-sm sm:text-base">Review your order summary, track delivery, or continue shopping.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="status-badge {{ $statusBadgeClass }}">
                        <i class="fa-solid {{ $statusIcon }}"></i>
                        {{ ucfirst($orderStatus) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- TAB NAVIGATION --}}
        <div class="flex flex-wrap gap-3 mb-8 border-b border-white/10 pb-4">
            <a href="#summary" 
               class="px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2 bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 shadow-lg shadow-indigo-500/10">
                <i class="fa-solid fa-list-ul"></i> Order Summary
            </a>
            <a href="#tracking" 
               class="px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2 text-gray-400 hover:text-white hover:bg-white/5">
                <i class="fa-solid fa-truck-fast"></i> Track My Order
            </a>
            <a href="{{ route('shop') }}" 
               class="px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2 text-emerald-400 hover:text-emerald-300 hover:bg-emerald-500/10 border border-emerald-500/20 hover:border-emerald-500/40">
                <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
            </a>
        </div>

        {{-- ORDER SUMMARY SECTION --}}
        <div id="summary" class="grid lg:grid-cols-12 gap-8">
            
            {{-- LEFT: ORDER ITEMS --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="checkout-card p-6 sm:p-8">
                    <div class="flex items-center justify-between border-b border-white/5 pb-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                                <i class="fa-solid fa-boxes-stacked text-indigo-400"></i>
                            </div>
                            <h2 class="text-white text-lg font-bold tracking-wide">Order Items</h2>
                        </div>
                        <span class="text-xs bg-white/5 text-gray-400 px-3 py-1 rounded-full border border-white/10">
                            {{ $itemCount }} Items
                        </span>
                    </div>
                    
                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2 custom-scroll">
                        @if($itemCount > 0)
                            @foreach($items as $item)
                                <div class="summary-item p-4 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        {{-- ✅ FIXED: SAME AS SHOP PAGE - asset($product->image) --}}
                                        <div class="w-12 h-12 rounded-lg bg-indigo-500/10 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                            @php
                                                $imagePath = $item['image'] ?? null;
                                                $imageUrl = null;
                                                
                                                if ($imagePath) {
                                                    // ✅ SAME AS SHOP PAGE: asset($product->image)
                                                    $imageUrl = asset($imagePath);
                                                }
                                            @endphp
                                            
                                           @if($imageUrl)
    <picture>
        @if($imagePath)
            <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $imagePath)) }}" type="image/webp">
        @endif
        <img src="{{ $imageUrl }}" 
             alt="{{ $item['name'] }}" 
             class="w-full h-full object-cover rounded-lg"
             onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fa-solid fa-box text-indigo-400 text-xl\'></i>'">
    </picture>
@else
                                                <i class="fa-solid fa-box text-indigo-400 text-xl"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-white font-semibold text-sm sm:text-base truncate">{{ $item['name'] ?? 'Unknown Item' }}</h4>
                                            <div class="flex items-center gap-3 mt-0.5">
                                                <span class="text-gray-400 text-xs">Qty: <span class="text-indigo-400 font-medium">{{ $item['qty'] ?? 1 }}</span></span>
                                                <span class="text-gray-600 text-xs">×</span>
                                                <span class="text-gray-400 text-xs">Rs {{ number_format($item['price'] ?? 0) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="text-white font-bold text-sm">Rs {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1)) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-12">
                                <i class="fa-solid fa-box-open text-4xl text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 text-sm">No item details available for this order.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT: ORDER SUMMARY CARD --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="checkout-card p-6 sm:p-8 border border-indigo-500/10 sticky top-10">
                    <h3 class="text-white text-xl font-black mb-6 tracking-wide">Order Summary</h3>
                    
                    {{-- Order Status --}}
                    <div class="bg-black/30 border border-white/5 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Order Status</p>
                            <span class="status-badge {{ $statusBadgeClass }}">
                                <i class="fa-solid {{ $statusIcon }}"></i>
                                {{ ucfirst($orderStatus) }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Customer Info --}}
                    <div class="bg-black/30 border border-white/5 rounded-xl p-4 mb-4">
                        <p class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-user text-indigo-400"></i> Shipping Details
                        </p>
                        <p class="text-white font-semibold text-sm">{{ $order->customer_name ?? $order->name ?? 'N/A' }}</p>
                        <p class="text-gray-300 text-xs mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-indigo-400 text-[10px]"></i>
                            {{ $order->address ?? 'N/A' }}
                        </p>
                        <p class="text-gray-300 text-xs">{{ $order->city ?? 'N/A' }} — {{ $order->postal_code ?? 'N/A' }}</p>
                        <p class="text-gray-400 text-xs mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-phone text-indigo-400 text-[10px]"></i>
                            {{ $order->phone ?? 'N/A' }}
                        </p>
                        <p class="text-gray-400 text-xs mt-0.5 flex items-center gap-1">
                            <i class="fa-regular fa-envelope text-indigo-400 text-[10px]"></i>
                            {{ $order->email ?? 'N/A' }}
                        </p>
                    </div>

                    {{-- Payment Info --}}
                    <div class="bg-black/30 border border-white/5 rounded-xl p-4 mb-4">
                        <p class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-credit-card text-indigo-400"></i> Payment Method
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-white font-semibold text-sm">{{ $order->payment_method ?? 'N/A' }}</span>
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full border {{ $paymentBadgeClass }}">
                                <i class="fa-solid {{ $paymentIcon }}"></i>
                                {{ $paymentStatus }}
                            </span>
                        </div>
                    </div>

                    {{-- Totals --}}
                    <div class="space-y-3 border-t border-white/10 pt-4">
                        <div class="flex justify-between text-sm text-gray-400">
                            <span>Subtotal</span>
                            <span class="text-white font-medium">Rs {{ number_format($order->total ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-400">
                            <span>Shipping</span>
                            <span class="text-emerald-400 font-semibold text-xs bg-emerald-500/10 px-2 py-0.5 rounded-md border border-emerald-500/20">FREE</span>
                        </div>
                        <div class="flex justify-between text-xl font-black pt-3 border-t border-white/10">
                            <span class="text-white">Total</span>
                            <span class="text-indigo-400">Rs {{ number_format($order->total ?? 0) }}</span>
                        </div>
                    </div>

                    {{-- Order Info --}}
                    <div class="mt-6 pt-4 border-t border-white/10 grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="text-gray-500 uppercase font-semibold text-[10px]">Order Date</p>
                            <p class="text-white font-medium">{{ isset($order) ? $order->created_at->format('d M, Y') : now()->format('d M, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 uppercase font-semibold text-[10px]">Order ID</p>
                            <p class="text-white font-mono font-medium text-[11px]">{{ $order->order_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TRACKING SECTION --}}
        <div id="tracking" class="max-w-3xl mx-auto mt-12">
            <div class="receipt-shell relative overflow-hidden">
                <div class="receipt-topbar"></div>
                <div class="p-8 sm:p-10">
                    <div class="flex items-center justify-between border-b border-white/[0.08] pb-6 mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                                <i class="fa-solid fa-truck-fast text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-white text-xl font-black tracking-wide">Track Your Order</h3>
                                <p class="text-xs text-gray-500 font-mono tracking-wide mt-0.5">
                                    Ref: {{ $order->order_number ?? 'N/A' }} · {{ isset($order) ? $order->created_at->format('d M, Y') : now()->format('d M, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="status-badge {{ $statusBadgeClass }}">
                                <i class="fa-solid {{ $statusIcon }}"></i>
                                {{ ucfirst($orderStatus) }}
                            </span>
                        </div>
                    </div>

                    {{-- Tracking Progress --}}
                    @php
                        $stages = [
                            ['label' => 'Order Confirmed', 'desc' => 'Your order has been received', 'icon' => 'fa-circle-check'],
                            ['label' => 'Processing', 'desc' => 'Preparing your items for shipment', 'icon' => 'fa-box-open'],
                            ['label' => 'Dispatched', 'desc' => 'Your parcel has left the warehouse', 'icon' => 'fa-truck-fast'],
                            ['label' => 'Delivered', 'desc' => 'Package handed over to you', 'icon' => 'fa-house-circle-check'],
                        ];
                    @endphp
                    
                    <div class="relative px-2 mb-10">
                        <div class="absolute top-[22px] left-6 right-6 h-1 track-line-bg rounded-full"></div>
                        <div class="absolute top-[22px] left-6 h-1 track-line-fill rounded-full"
                             style="width: calc({{ $trackingStep }} / 3 * 100% - {{ $trackingStep }} * 16px);"></div>
                        <div class="relative flex justify-between">
                            @foreach($stages as $index => $stage)
                                <div class="flex flex-col items-center gap-2 w-1/4">
                                    <div class="track-node 
                                        @if($index < $trackingStep) done 
                                        @elseif($index === $trackingStep) done current 
                                        @endif">
                                        <i class="fa-solid text-sm {{ $stage['icon'] }}"></i>
                                    </div>
                                    <p class="text-[11px] font-bold text-center leading-tight mt-2 
                                        @if($index <= $trackingStep) text-white @else text-gray-500 @endif">
                                        {{ $stage['label'] }}
                                    </p>
                                    <p class="text-[9px] text-gray-500 text-center hidden sm:block">{{ $stage['desc'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Status Details --}}
                    <div class="bg-black/30 border border-white/[0.06] rounded-2xl p-6 mb-6">
                        <p class="text-[10px] uppercase font-bold tracking-wider text-cyan-400 mb-1">Current Status</p>
                        <p class="text-white font-bold text-lg">{{ $stages[$trackingStep]['label'] ?? 'Order Placed' }}</p>
                        <p class="text-gray-400 text-sm mt-1">{{ $stages[$trackingStep]['desc'] ?? 'Your order has been placed' }}</p>
                        <div class="mt-3 flex items-center gap-2 text-xs">
                            <span class="text-gray-500">Last updated:</span>
                            <span class="text-gray-400">{{ now()->format('d M Y, h:i A') }}</span>
                        </div>
                        @if($trackingStep === 3)
                            <p class="text-emerald-400 text-xs mt-3 flex items-center gap-1.5 font-semibold">
                                <i class="fa-solid fa-circle-check"></i> Your parcel has been delivered successfully. 🎉
                            </p>
                        @endif
                    </div>

                    {{-- Delivery Info --}}
                    <div class="grid grid-cols-2 gap-4 text-xs mb-6">
                        <div class="bg-white/[0.02] border border-white/5 rounded-xl p-4">
                            <p class="text-gray-500 uppercase font-semibold text-[10px] mb-1 flex items-center gap-1">
                                <i class="fa-solid fa-user text-indigo-400"></i> Deliver To
                            </p>
                            <p class="text-white font-medium text-sm">{{ $order->customer_name ?? $order->name ?? 'N/A' }}</p>
                            <p class="text-gray-400 text-xs mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-indigo-400 text-[10px]"></i>
                                {{ $order->city ?? 'N/A' }}
                            </p>
                            <p class="text-gray-400 text-xs flex items-center gap-1">
                                <i class="fa-solid fa-phone text-indigo-400 text-[10px]"></i>
                                {{ $order->phone ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-white/[0.02] border border-white/5 rounded-xl p-4">
                            <p class="text-gray-500 uppercase font-semibold text-[10px] mb-1 flex items-center gap-1">
                                <i class="fa-solid fa-credit-card text-indigo-400"></i> Payment
                            </p>
                            <p class="text-white font-medium text-sm">{{ $order->payment_method ?? 'N/A' }}</p>
                            <p class="text-gray-400 text-xs mt-1">{{ 'Order #' . ($order->order_number ?? 'N/A') }}</p>
                            <p class="text-gray-400 text-xs">Items: {{ $itemCount }}</p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-white/[0.08]">
                        <a href="#summary" 
                           class="flex-1 receipt-cta px-6 py-3.5 rounded-xl text-sm font-bold transition flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Summary
                        </a>
                        <a href="{{ route('shop') }}" 
                           class="flex-1 gradient-btn px-6 py-3.5 rounded-xl text-white font-bold text-sm tracking-wide shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
