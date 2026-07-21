@extends('layouts.app')

@section('title', $product->name . ' - Product Details')

@section('content')

<div class="shop-bg py-16">
<div class="max-w-6xl mx-auto px-6 lg:px-8">

  <a href="{{ url()->previous() }}" class="text-indigo-400 text-sm font-bold mb-6 inline-block">
    ← Back to Shop
  </a>

  <div
    x-data="{
        wished: false,
        added: false,
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
            })
            .then(res => res.json())
            .then(data => {
                window.dispatchEvent(new CustomEvent('cart-toast', { detail: data.message || 'Added to wishlist!' }));
            })
            .catch(() => {});
        }
    }"
    class="grid lg:grid-cols-2 gap-10">

    {{-- PRODUCT IMAGE --}}
    <div class="product-card overflow-hidden">
     @if($product->image)
    <picture>
        <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $product->image)) }}" type="image/webp">
        <img src="{{ asset($product->image) }}"
             alt="{{ $product->name }}"
             class="w-full h-[450px] object-cover">
    </picture>
@else
        <img src="https://via.placeholder.com/800x800"
             alt="{{ $product->name }}"
             class="w-full h-[450px] object-cover">
      @endif
    </div>

    {{-- PRODUCT INFO --}}
    <div class="space-y-5">

      <h1 class="text-4xl font-black text-white">
        {{ $product->name }}
      </h1>

      <p class="text-gray-500 text-sm leading-relaxed">
        {{ $product->description }}
      </p>

      <div class="flex items-center gap-4">
        <span class="text-indigo-400 text-3xl font-black">
          Rs {{ number_format($product->new_price) }}
        </span>
        <span class="text-yellow-400 text-sm">★★★★★</span>
      </div>

      {{-- BUTTONS --}}
      <div class="flex gap-3 pt-4">

        {{-- ADD TO CART --}}
        <form action="{{ route('cart.add', $product->id) }}" method="POST"
              @submit.prevent="addToCart($event)" class="flex-1">
          @csrf
          <button type="submit"
                  class="w-full py-3 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-2"
                  :class="added
                      ? 'bg-emerald-600'
                      : 'bg-indigo-600 hover:bg-indigo-700'">
            <template x-if="!added">
              <span>Add to Cart</span>
            </template>
            <template x-if="added">
              <span class="flex items-center gap-2">
                <i class="fa-solid fa-check text-xs"></i> Added!
              </span>
            </template>
          </button>
        </form>

        {{-- WISHLIST HEART --}}
        <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
              @submit.prevent="addToWishlist($event)">
          @csrf
          <button type="submit"
                  class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors duration-300"
                  :class="wished ? 'heartbeat bg-pink-600 text-white' : 'bg-white/5 text-white hover:bg-pink-600'">
            <i :class="wished ? 'fa-solid' : 'fa-regular'" class="fa-heart"></i>
          </button>
        </form>

      </div>

      {{-- DETAILS --}}
      <div class="pt-6 border-t border-white/10 text-sm text-gray-400 space-y-2">
        <p>✔ Free Delivery Available</p>
        <p>✔ 7 Days Return Policy</p>
        <p>✔ Cash on Delivery</p>
      </div>

    </div>

  </div>

</div>
</div>

{{-- TOAST NOTIFICATION --}}
<div
    x-data="{ show: false, message: '' }"
    x-on:cart-toast.window="message = $event.detail; show = true; setTimeout(() => show = false, 2000)"
    x-show="show"
    x-transition
    x-cloak
    class="fixed bottom-6 right-6 z-50">
    <div class="bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-semibold">
        <i class="fa-solid fa-check"></i>
        <span x-text="message"></span>
    </div>
</div>

<style>
@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    30% { transform: scale(1.35); }
    50% { transform: scale(0.95); }
    70% { transform: scale(1.15); }
}
.heartbeat {
    animation: heartbeat 0.5s ease;
}
[x-cloak] { display: none !important; }
</style>

@endsection
