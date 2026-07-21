@extends('layouts.app')

@section('content')

<style>
.cart-bg{
    background:#0d0e12;
    min-height:100vh;
}
.cart-card{
    background:#141518;
    border:1px solid rgba(255,255,255,.06);
    border-radius:1.25rem;
}
.cart-item{
    background:#141518;
    border:1px solid rgba(255,255,255,.06);
    border-radius:1rem;
    transition:.3s;
}
.cart-item:hover{
    border-color:rgba(99,102,241,.35);
    transform:translateY(-3px);
}
.qty-input{
    width:70px;
    background:#0d0e12;
    border:1px solid rgba(255,255,255,.08);
    color:#fff;
    border-radius:.6rem;
    text-align:center;
    padding:6px;
}
</style>

<div class="cart-bg py-16">

<div class="max-w-7xl mx-auto px-6 lg:px-8">

<div class="mb-10">
    <h1 class="text-4xl font-black text-white">
        Shopping Cart
    </h1>

    <p class="text-gray-500 mt-2">
        Review your selected items before checkout
    </p>
</div>

@php
$cart = session('cart',[]);
$total = 0;
@endphp

@if(count($cart))

<div class="grid lg:grid-cols-3 gap-8">

<div class="lg:col-span-2 space-y-5">

@foreach($cart as $id=>$item)

@php
$subtotal = $item['new_price'] * $item['quantity'];
$total += $subtotal;
@endphp

<div class="cart-item p-5 flex flex-col md:flex-row gap-5">

<picture>
    @if($item['image'])
        <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $item['image'])) }}" type="image/webp">
    @endif
    <img
    src="{{ $item['image'] ? asset($item['image']) : 'https://via.placeholder.com/300' }}"
    class="w-32 h-32 rounded-xl object-cover">
</picture>

<div class="flex-1">

<h3 class="text-white font-bold text-lg">
{{ $item['name'] }}
</h3>

<p class="text-indigo-400 font-bold mt-2">
Rs {{ number_format($item['new_price']) }}
</p>

<p class="text-gray-400 text-sm mt-1">
Subtotal :
Rs {{ number_format($subtotal) }}
</p>

<div class="flex flex-wrap items-center gap-3 mt-5">

<form action="{{ route('cart.update',$id) }}" method="POST" class="flex items-center gap-2">
    @csrf
    <input
        type="number"
        name="quantity"
        min="1"
        value="{{ $item['quantity'] }}"
        class="qty-input"
        onchange="this.form.submit()">
</form>

<form action="{{ route('cart.remove',$id) }}" method="POST">
@csrf
<button
class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition">
<i class="fa-solid fa-trash mr-2"></i>
Remove
</button>
</form>

</div>

</div>

</div>

@endforeach

<form action="{{ route('cart.clear') }}" method="POST">
@csrf
<button
class="mt-2 px-6 py-3 rounded-xl bg-red-700 hover:bg-red-600 text-white font-bold">
Clear Cart
</button>
</form>

</div>

<div>

<div class="cart-card p-6 sticky top-10">

<h2 class="text-white text-2xl font-black mb-6">
Order Summary
</h2>

<div class="space-y-4">

<div class="flex justify-between text-gray-400">
<span>Subtotal</span>
<span>Rs {{ number_format($total) }}</span>
</div>

<div class="flex justify-between text-gray-400">
<span>Shipping</span>
<span>Free</span>
</div>

<hr class="border-white/10">

<div class="flex justify-between text-white text-xl font-black">
<span>Total</span>
<span>Rs {{ number_format($total) }}</span>
</div>

</div>

<a
href="{{ route('checkout') }}"
class="block mt-8 text-center py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold">
Proceed to Checkout
</a>

<a
href="{{ route('shop') }}"
class="block mt-4 text-center text-gray-400 hover:text-white">
Continue Shopping
</a>

</div>

</div>

</div>

@else

<div class="cart-card py-24 text-center">

<i class="fa-solid fa-cart-shopping text-6xl text-indigo-500"></i>

<h2 class="text-white text-3xl font-black mt-6">
Your Cart is Empty
</h2>

<p class="text-gray-500 mt-3">
Looks like you haven't added any products yet.
</p>

<a
href="{{ route('shop') }}"
class="inline-block mt-8 px-8 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold">
Go to Shop
</a>

</div>

@endif

</div>

</div>

@endsection