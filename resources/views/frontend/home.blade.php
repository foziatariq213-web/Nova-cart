@extends('layouts.app')
@section('content')
<style>
.products-bg {
    min-height: 100vh;
    background: radial-gradient(circle at top left, #3730a3 0%, transparent 35%),
                radial-gradient(circle at bottom right, #0ea5e9 0%, transparent 35%),
                #090b10;
    position: relative;
    overflow: hidden;
}
.product-card {
    background: rgba(22, 28, 42, 0.78);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 1.5rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.product-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.04), transparent);
    transform: translateX(-100%);
    transition: 0.7s;
    pointer-events: none;
}
.product-card:hover::before {
    transform: translateX(100%);
}
.product-img-wrap {
    overflow: hidden;
    border-radius: 1.5rem 1.5rem 0 0;
    position: relative;
    width: 100%;
    height: 200px;
    flex-shrink: 0;
}
.product-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
.product-card:hover .product-img-wrap img {
    transform: scale(1.05);
}
.quick-action {
    transform: translateX(12px);
    opacity: 0;
    transition: 0.3s ease;
}
.product-card:hover .quick-action {
    transform: translateX(0);
    opacity: 1;
}
.shine {
    position: absolute;
    inset: 0;
    background: linear-gradient(115deg, transparent 20%, rgba(255, 255, 255, 0.08) 40%, transparent 60%);
    transform: translateX(-100%);
    transition: transform 0.8s ease;
    pointer-events: none;
}
.product-card:hover .shine {
    transform: translateX(100%);
}
.stars {
    color: #fbbf24;
    letter-spacing: 1px;
    text-shadow: 0 0 8px rgba(251, 191, 36, 0.4);
}
@keyframes fade-up {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}
.reveal {
    opacity: 0;
}
.reveal.is-visible {
    animation: fade-up 0.6s ease forwards;
}
@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    30% { transform: scale(1.35); }
    50% { transform: scale(0.95); }
    70% { transform: scale(1.15); }
}
.heartbeat {
    animation: heartbeat 0.5s ease;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: .4; transform: scale(1.4); }
}
.pulse-dot {
    animation: pulse-dot 1.6s ease-in-out infinite;
}
.name-underline {
    position: relative;
    display: inline-block;
}
.name-underline::after {
    content: '';
    position: absolute;
    left: 0; bottom: -2px;
    width: 0; height: 1px;
    background: #818cf8;
    transition: width 0.3s ease;
}
.product-card:hover .name-underline::after {
    width: 100%;
}
.badge-new {
    background: linear-gradient(90deg, #10b981, #059669);
}
.badge-hot {
    background: linear-gradient(90deg, #f43f5e, #e11d48);
}
@keyframes img-shimmer {
    0% { background-position: -400px 0; }
    100% { background-position: 400px 0; }
}
.img-skeleton {
    background: #1c2233;
    background-image: linear-gradient(90deg, #1c2233 0px, #262e45 40px, #1c2233 80px);
    background-size: 600px 100%;
    animation: img-shimmer 1.4s linear infinite;
}
/* Header Slide-in */
.header-anim {
    animation: fadeTop 0.7s ease;
}
@keyframes fadeTop {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
/* Floating Glow Shapes */
.floating {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.18;
    animation: float 8s infinite alternate;
    pointer-events: none;
}
.one {
    width: 280px;
    height: 280px;
    background: #4f46e5;
    top: -80px;
    left: -80px;
}
.two {
    width: 240px;
    height: 240px;
    background: #06b6d4;
    right: -50px;
    top: 150px;
}
.three {
    width: 200px;
    height: 200px;
    background: #8b5cf6;
    bottom: 60px;
    left: 45%;
}
@keyframes float {
    100% {
        transform: translateY(40px) translateX(30px);
    }
}
[x-cloak] { display: none !important; }

/* Product Info */
.product-info {
    padding: 16px 18px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.product-info h6 {
    font-size: 14px;
    font-weight: 700;
    color: white;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.product-info .price {
    font-size: 18px;
    font-weight: 700;
    color: #818cf8;
}
.product-info .btn-details {
    width: 100%;
    padding: 8px 0;
    border-radius: 10px;
    background: rgba(34, 36, 44, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.06);
    color: #d1d5db;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    text-decoration: none;
}
.product-info .btn-details:hover {
    background: rgba(34, 36, 44, 1);
    border-color: rgba(99, 102, 241, 0.4);
    color: white;
}
.product-info .btn-cart {
    width: 100%;
    padding: 8px 0;
    border-radius: 10px;
    border: none;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.product-info .btn-cart:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px -8px rgba(79, 70, 229, 0.5);
}
.product-info .btn-cart.added {
    background: #10b981;
}
.product-info .btn-cart:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<div class="products-bg py-12">
    <!-- Floating Background Orbs -->
    <div class="floating one"></div>
    <div class="floating two"></div>
    <div class="floating three"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        {{-- SECTION HEADER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 header-anim">
            <div>
                <p class="text-indigo-400 text-xs font-bold tracking-[0.2em] uppercase mb-1 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 pulse-dot"></span>
                    Just Landed
                </p>
                <h2 class="text-2xl sm:text-3xl font-black text-white">
                    Featured <span class="text-indigo-400">Products</span>
                </h2>
            </div>
            <a href="{{ route('shop') }}" class="text-sm font-semibold text-gray-400 hover:text-indigo-400 transition flex items-center gap-2 group">
                View All Products
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">

            @forelse($products as $index => $product)
                <div
                    x-data="{
                        visible: false,
                        wished: false,
                        added: false,
                        imgLoaded: false,
                        addToCart(e){
                            this.added = true;
                            setTimeout(() => this.added = false, 1600);
                            const form = e.target.closest('form');
                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json'
                                },
                                body: new FormData(form)
                            })
                            .then(res => res.json())
                            .then(data => {
                                window.dispatchEvent(new CustomEvent('cart-toast', { detail: data.message || 'Added to cart!' }));
                            })
                            .catch(() => {});
                        },
                        addToWishlist(e){
                            this.wished = true;
                            setTimeout(() => this.wished = false, 500);
                            const form = e.target.closest('form');
                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json'
                                },
                                body: new FormData(form)
                            }).catch(() => {});
                        }
                    }"
                    x-init="
                        $nextTick(() => {
                            const obs = new IntersectionObserver((entries) => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting) {
                                        visible = true;
                                        obs.disconnect();
                                    }
                                });
                            }, { threshold: 0.1 });
                            obs.observe($el);
                        })
                    "
                    :class="visible ? 'is-visible' : ''"
                    class="product-card reveal"
                    style="animation-delay: {{ $index * 70 }}ms">

                    {{-- IMAGE WRAPPER --}}
                    <div class="product-img-wrap">
                        <div class="img-skeleton absolute inset-0" x-show="!imgLoaded" x-cloak></div>
                        
                       <picture>
    @if($product->image)
        <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $product->image)) }}" type="image/webp">
    @endif
    <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/400x400/1e1f24/6366f1?text=No+Image' }}"
         alt="{{ $product->name }}"
         loading="lazy"
         x-on:load="imgLoaded = true"
         x-bind:class="imgLoaded ? 'opacity-100' : 'opacity-0'"
         class="transition-opacity duration-500">
</picture>

                        <div class="shine"></div>

                        {{-- BADGES --}}
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5 items-start">
                            @if($product->created_at && $product->created_at->diffInDays(now()) <= 2)
                                <span class="badge-new px-2.5 py-0.5 rounded-full text-[10px] font-bold text-white shadow-lg">
                                    NEW
                                </span>
                            @elseif($index < 2)
                                <span class="badge-hot px-2.5 py-0.5 rounded-full text-[10px] font-bold text-white shadow-lg flex items-center gap-1">
                                    <i class="fa-solid fa-fire text-[9px]"></i> HOT
                                </span>
                            @endif
                        </div>

                        {{-- QUICK ACTIONS --}}
                        <div class="absolute top-3 right-3 flex flex-col gap-2">
                            <form action="{{ route('wishlist.add', $product->id) }}" method="POST" @submit.prevent="addToWishlist($event)">
                                @csrf
                                <button type="submit"
                                    class="quick-action w-8 h-8 rounded-full bg-black/50 backdrop-blur-md border border-white/10 flex items-center justify-center text-gray-200 hover:bg-pink-600 hover:text-white hover:border-pink-500 transition-colors duration-300"
                                    :class="wished ? 'heartbeat bg-pink-600 text-white border-pink-500' : ''">
                                    <i :class="wished ? 'fa-solid' : 'fa-regular'" class="fa-heart text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- PRODUCT INFO --}}
                    <div class="product-info">
                        <h6 class="name-underline">{{ $product->name }}</h6>
                        <div class="stars text-[10px] mb-2">★★★★★</div>
                        <div class="flex items-center justify-between mb-3 mt-auto">
                            <span class="price">Rs {{ number_format($product->new_price, 0) }}</span>
                            <span class="text-xs text-gray-500">{{ $product->category->name ?? '' }}</span>
                        </div>

                        <div class="flex flex-col gap-2">
                            <a href="{{ route('product.details', $product->id) }}" class="btn-details">
                                View Details
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" @submit.prevent="addToCart($event)">
                                @csrf
                                <button type="submit" class="btn-cart" :class="added ? 'added' : ''">
                                    <template x-if="!added">
                                        <span class="flex items-center gap-2">
                                            <i class="fa-solid fa-cart-plus text-xs"></i> Add to Cart
                                        </span>
                                    </template>
                                    <template x-if="added">
                                        <span class="flex items-center gap-2">
                                            <i class="fa-solid fa-check text-xs"></i> Added!
                                        </span>
                                    </template>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-16 h-16 rounded-full bg-indigo-500/10 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-box-open text-2xl text-indigo-400"></i>
                    </div>
                    <h4 class="text-white text-lg font-bold mb-1">No products available</h4>
                    <p class="text-gray-500 text-sm">Check back soon, new arrivals are on the way.</p>
                </div>
            @endforelse

        </div>

    </div>
</div>

{{-- TOAST --}}
<div x-data="{ show: false, message: '' }"
     x-on:cart-toast.window="message = $event.detail; show = true; setTimeout(() => show = false, 2500)"
     x-show="show"
     x-transition
     x-cloak
     class="fixed bottom-6 right-6 z-50">
    <div class="bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-semibold">
        <i class="fa-solid fa-check-circle"></i>
        <span x-text="message"></span>
    </div>
</div>

@endsection