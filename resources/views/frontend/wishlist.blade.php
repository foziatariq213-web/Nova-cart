@extends('layouts.app')

@section('content')

<style>
.wishlist-bg{
    background:#0d0e12;
    min-height:100vh;
}

.wishlist-card{
    background:#141518;
    border:1px solid rgba(255,255,255,.06);
    border-radius:20px;
    overflow:hidden;
    transition:.3s;
}

.wishlist-card:hover{
    transform:translateY(-6px);
    border-color:#6366f1;
    box-shadow:0 20px 40px rgba(99,102,241,.2);
}

.wishlist-img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.empty-box{
    background:#16181d;
    border-radius:20px;
}
</style>

<div class="wishlist-bg py-16">

<div class="max-w-7xl mx-auto px-6">

    <div class="mb-10">
        <h1 class="text-4xl font-black text-white">
            My Wishlist
        </h1>

        <p class="text-gray-400 mt-2">
            Your saved products
        </p>
    </div>

    @if(count($wishlist))

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

        @foreach($wishlist as $item)

        <div class="wishlist-card">

            <picture>
    @if($item['image'])
        <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $item['image'])) }}" type="image/webp">
    @endif
    <img
        src="{{ asset($item['image']) }}"
        class="wishlist-img"
        alt="{{ $item['name'] }}">
</picture>

            <div class="p-5">

                <h3 class="text-white font-bold">
                    {{ $item['name'] }}
                </h3>

                <p class="text-indigo-400 font-bold mt-2">
                    Rs {{ number_format($item['price']) }}
                </p>

                <div class="flex gap-2 mt-5">

                    <form
                        action="{{ route('cart.add',$item['id']) }}"
                        method="POST"
                        class="flex-1">

                        @csrf

                        <button
                            class="w-full bg-indigo-600 hover:bg-indigo-700 py-2 rounded-lg text-white font-semibold">

                            Add To Cart

                        </button>

                    </form>

                    <form
                        action="{{ route('wishlist.remove',$item['id']) }}"
                        method="POST">

                        @csrf

                        <form
    action="{{ route('wishlist.remove',$item['id']) }}"
    method="POST">

    @csrf

    <button
        class="px-4 h-10 flex items-center gap-2 rounded-lg
               bg-red-600 hover:bg-red-700
               text-white font-semibold text-sm
               transition duration-300 hover:scale-105">

        <i class="fa-solid fa-trash"></i>
        Remove

    </button>

</form>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    @else

    <div class="empty-box text-center py-20">

        <i class="fa-regular fa-heart text-6xl text-indigo-500"></i>

        <h2 class="text-white text-2xl font-bold mt-6">
            Wishlist is Empty
        </h2>

        <p class="text-gray-400 mt-2">
            Save your favourite products here.
        </p>

        <a
            href="{{ route('shop') }}"
            class="inline-block mt-6 bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-lg text-white">

            Continue Shopping

        </a>

    </div>

    @endif

</div>

</div>

@endsection
