@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<div class="shop-bg py-16 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-10 relative">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <p class="text-indigo-400 text-xs font-black tracking-[0.25em] uppercase mb-2 flex items-center gap-2">
                        <span class="w-8 h-px bg-indigo-500/50"></span>
                        Order History
                    </p>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                        My Orders
                    </h1>
                    <div class="h-1 w-20 bg-gradient-to-r from-indigo-500 to-purple-500 mt-4 rounded-full"></div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-gray-400 text-sm bg-white/5 px-4 py-2 rounded-xl border border-white/5">
                        <i class="fa-regular fa-clipboard text-indigo-400 mr-2"></i>
                        {{ $orders->count() }} {{ Str::plural('Order', $orders->count()) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-6 px-5 py-4 rounded-xl bg-emerald-600/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium flex items-center gap-3 backdrop-blur-md shadow-lg shadow-emerald-950/20 transition-all duration-300 animate-slide-down">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <i class="fa-regular fa-circle-check text-emerald-400"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 px-5 py-4 rounded-xl bg-rose-600/10 border border-rose-500/20 text-rose-400 text-sm font-medium flex items-center gap-3 backdrop-blur-md shadow-lg shadow-rose-950/20 transition-all duration-300 animate-slide-down">
                <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                <i class="fa-regular fa-circle-xmark text-rose-400"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Orders List --}}
        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    @php
                        $orderStatus = $order->order_status ?? $order->status ?? 'pending';
                        $orderStatusLower = strtolower($orderStatus);
                        
                        // FIX: COD orders jab tak deliver nahi hote, unka payment status
                        // ab "Pending" ke bajaye "Unpaid" dikhega — taake Order Status
                        // (jo khud "Pending" hota hai) ke sath duplicate na lage, aur ye
                        // zyada accurate bhi hai (COD = paisa abhi tak wasool nahi hua).
                        if($orderStatusLower === 'cancelled') {
                            $paymentStatus = 'Unpaid';
                            $paymentBadgeClass = 'bg-rose-500/10 text-rose-400 border-rose-500/20';
                            $dotColor = 'bg-rose-400';
                        } 
                        elseif($order->payment_method === 'Cash on Delivery' && $orderStatusLower !== 'delivered') {
                            $paymentStatus = 'Unpaid';
                            $paymentBadgeClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                            $dotColor = 'bg-amber-400';
                        }
                        elseif($order->payment_method === 'Cash on Delivery' && $orderStatusLower === 'delivered') {
                            $paymentStatus = 'Paid';  // Delivered COD bhi Paid show karega
                            $paymentBadgeClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                            $dotColor = 'bg-emerald-400';
                        }
                        elseif($order->payment_method === 'Credit Card') {
                            // Card orders ka asli status Stripe se aata hai (webhook DB mein
                            // update karta hai) — isliye yahan guess nahi, DB wala status dikhao.
                            if($order->payment_status === 'Paid') {
                                $paymentStatus = 'Paid';
                                $paymentBadgeClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                                $dotColor = 'bg-emerald-400';
                            } else {
                                $paymentStatus = 'Unpaid';
                                $paymentBadgeClass = 'bg-rose-500/10 text-rose-400 border-rose-500/20';
                                $dotColor = 'bg-rose-400';
                            }
                        }
                        else {
                            $paymentStatus = 'Paid';
                            $paymentBadgeClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                            $dotColor = 'bg-emerald-400';
                        }
                        
                        $canCancel = !in_array($orderStatusLower, ['cancelled', 'delivered']) && Carbon\Carbon::parse($order->created_at)->diffInDays(now()) < 3;
                        $isCancelled = $orderStatusLower === 'cancelled';
                        
                        // Get item count
                        $itemCount = 0;
                        if (isset($order->items) && $order->items !== null) {
                            if ($order->items instanceof \Illuminate\Database\Eloquent\Collection) {
                                $itemCount = $order->items->count();
                            } elseif (is_array($order->items)) {
                                $itemCount = count($order->items);
                            }
                        }
                    @endphp
                    
                    <div class="group relative overflow-hidden bg-gradient-to-br from-white/[0.03] to-transparent border border-white/5 hover:border-indigo-500/30 rounded-2xl p-5 sm:p-6 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-indigo-950/30">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/0 via-indigo-500/5 to-purple-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                        
                        <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                            
                            {{-- Left: Order Info --}}
                            <div class="flex items-start gap-4 min-w-0">
                                <div class="hidden sm:flex flex-shrink-0 w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-500/20 items-center justify-center text-indigo-400 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fa-solid fa-receipt text-lg"></i>
                                </div>
                                
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-3 mb-1 flex-wrap">
                                        <p class="text-white font-extrabold text-base sm:text-lg tracking-wide group-hover:text-indigo-400 transition-colors duration-300 truncate">
                                            #{{ $order->order_number }}
                                        </p>
                                        <div class="flex lg:hidden items-center gap-2">
                                            <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold tracking-wide border {{ $paymentBadgeClass }}">
                                                {{ $paymentStatus }}
                                            </span>
                                            @if($orderStatusLower !== 'pending')
                                            <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold tracking-wide border
                                                @if($orderStatusLower === 'delivered') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                                @elseif($orderStatusLower === 'cancelled') bg-rose-500/10 text-rose-400 border-rose-500/20
                                                @elseif($orderStatusLower === 'shipped') bg-blue-500/10 text-blue-400 border-blue-500/20
                                                @else bg-white/[0.03] text-gray-300 border-white/10
                                                @endif">
                                                {{ ucfirst($orderStatus) }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400">
                                        <i class="fa-regular fa-calendar text-indigo-400"></i>
                                        <span>{{ Carbon\Carbon::parse($order->created_at)->setTimezone('Asia/Karachi')->format('d M Y') }}</span>
                                        <span class="text-gray-600">•</span>
                                        <i class="fa-regular fa-clock text-indigo-400"></i>
                                        <span>{{ Carbon\Carbon::parse($order->created_at)->setTimezone('Asia/Karachi')->format('h:i A') }}</span>
                                        @if($itemCount > 0)
                                            <span class="text-gray-600">•</span>
                                            <span class="text-gray-500">{{ $itemCount }} {{ Str::plural('item', $itemCount) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Right: Actions --}}
                            <div class="flex flex-wrap items-center justify-between lg:justify-end gap-3 lg:gap-4 pt-4 lg:pt-0 border-t border-white/5 lg:border-none w-full lg:w-auto">
                                
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-500 text-xs font-bold uppercase tracking-wider hidden sm:inline">Total</span>
                                    <span class="text-white font-black text-lg sm:text-xl tracking-tight">
                                        <span class="text-indigo-400 text-sm font-bold mr-0.5">Rs</span>{{ number_format($order->total) }}
                                    </span>
                                </div>

                                <div class="hidden lg:flex items-center gap-2">
                                    {{-- ✅ Payment Status Badge --}}
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold tracking-wide border backdrop-blur-md {{ $paymentBadgeClass }}">
                                        <span class="w-1.5 h-1.5 inline-block rounded-full mr-1.5 {{ $dotColor }}"></span>
                                        {{ $paymentStatus }}
                                    </span>
                                    @if($orderStatusLower !== 'pending')
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold tracking-wide border backdrop-blur-md
                                        @if($orderStatusLower === 'delivered') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                        @elseif($orderStatusLower === 'cancelled') bg-rose-500/10 text-rose-400 border-rose-500/20
                                        @elseif($orderStatusLower === 'shipped') bg-blue-500/10 text-blue-400 border-blue-500/20
                                        @else bg-white/[0.03] text-gray-300 border-white/10
                                        @endif">
                                        {{ ucfirst($orderStatus) }}
                                    </span>
                                    @endif
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center gap-2">
                                    @if($isCancelled)
                                        {{-- ✅ Delete Button for Cancelled Orders --}}
                                        <form action="{{ route('orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this order? This action cannot be undone.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    title="Delete Order Permanently" 
                                                    class="px-3 py-1.5 rounded-xl bg-red-600/10 hover:bg-red-600 border border-red-500/20 hover:border-red-500 text-red-400 hover:text-white text-xs font-bold transition-all duration-300 flex items-center gap-1.5 shadow-md transform hover:scale-105 hover:shadow-red-500/20">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                                <span class="hidden sm:inline">Delete</span>
                                            </button>
                                        </form>
                                    @elseif($canCancel)
                                        {{-- ✅ Cancel Button for Active Orders --}}
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');" class="inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" 
                                                    title="Cancel Order" 
                                                    class="px-3 py-1.5 rounded-xl bg-rose-600/10 hover:bg-rose-600 border border-rose-500/20 hover:border-rose-500 text-rose-400 hover:text-white text-xs font-bold transition-all duration-300 flex items-center gap-1.5 shadow-md transform hover:scale-105 hover:shadow-rose-500/20">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                                <span class="hidden sm:inline">Cancel</span>
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('orders.show', $order->id) }}" 
                                       title="View Summary & Track Order"
                                       class="w-9 h-9 rounded-xl bg-indigo-600/10 hover:bg-indigo-600 border border-indigo-500/20 hover:border-indigo-500 flex items-center justify-center text-indigo-400 hover:text-white transition-all duration-300 shadow-md transform hover:scale-105 hover:shadow-indigo-500/20 group/btn">
                                        <i class="fa-solid fa-eye text-sm group-hover/btn:scale-110 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(isset($orders) && method_exists($orders, 'links'))
                <div class="mt-10">
                    {{ $orders->links() }}
                </div>
            @endif

        @else
            {{-- Empty State --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-white/[0.02] to-transparent border border-dashed border-white/10 rounded-3xl text-center py-20 px-6 backdrop-blur-sm">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/5 to-purple-500/5 opacity-50"></div>
                <div class="relative">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-500/20 flex items-center justify-center mx-auto mb-6 shadow-xl shadow-indigo-950/20 group-hover:scale-110 transition-transform duration-500">
                        <i class="fa-solid fa-box-open text-4xl text-indigo-400 animate-float"></i>
                    </div>
                    <h4 class="text-white text-2xl font-extrabold mb-3 tracking-tight">No Orders Yet</h4>
                    <p class="text-gray-400 text-sm max-w-md mx-auto mb-8 leading-relaxed">
                        You haven't placed any orders yet. Start exploring our collection and find something you'll love!
                    </p>
                    <a href="{{ route('shop') }}"
                       class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-600 text-white text-sm font-extrabold tracking-wide transition-all duration-300 shadow-lg shadow-indigo-600/25 hover:shadow-indigo-600/40 transform hover:-translate-y-0.5 hover:scale-105">
                        Start Shopping
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    .animate-slide-down {
        animation: slideDown 0.4s ease-out;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@endsection