@extends('layouts.app')

@section('content')

<style>
.shop-bg{
  background:#0b0f17;
  min-height:100vh;
}

/* cards */
.product-card{
  background:#161c2a;
  border:1px solid rgba(255,255,255,.06);
  border-radius:1.5rem;
  transition:.35s ease;
  overflow:hidden;
}
.product-card:hover{
  transform:translateY(-8px);
  box-shadow:0 20px 60px rgba(99,102,241,.15);
  border-color:rgba(99,102,241,.25);
}

/* filter */
.filter-box{
  background:#161c2a;
  border:1px solid rgba(255,255,255,.06);
  border-radius:1.25rem;
}

/* input */
.input-dark{
  background:#161c2a;
  border:1px solid rgba(255,255,255,.08);
  color:white;
}

/* empty state */
@keyframes float-soft{
  0%,100%{ transform:translateY(0); }
  50%{ transform:translateY(-10px); }
}
.empty-icon{
  animation:float-soft 3s ease-in-out infinite;
}

@keyframes heartbeat{
  0%,100%{ transform:scale(1); }
  30%{ transform:scale(1.35); }
  50%{ transform:scale(0.95); }
  70%{ transform:scale(1.15); }
}
.heartbeat{
  animation:heartbeat .5s ease;
}
</style>

<div class="shop-bg py-20">

<div class="max-w-7xl mx-auto px-6 lg:px-8">

  {{-- HEADER --}}
  <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-12">

    <div>
      <h1 class="text-5xl font-black text-white tracking-tight">
        Shop <span class="text-indigo-400">Premium</span>
      </h1>
      <p class="text-gray-500 mt-2 text-sm">
        Curated luxury products for modern lifestyle
      </p>
    </div>

  </div>

  <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

    {{-- FILTER SIDEBAR --}}
    <div class="space-y-6">

      {{-- CATEGORIES --}}
      <div class="filter-box p-6">
        <h3 class="text-white font-bold mb-4">Categories</h3>

        <form action="{{ route('shop') }}" method="GET">

          {{-- preserve other filters when category changes --}}
          <input type="hidden" name="min_price" value="{{ request('min_price') }}">
          <input type="hidden" name="max_price" value="{{ request('max_price') }}">
          @foreach(request('brands', []) as $b)
            <input type="hidden" name="brands[]" value="{{ $b }}">
          @endforeach
          @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
          @endif

          <ul class="space-y-3">
            @foreach($categories as $category)
            <li>
              <label class="flex items-center gap-3 text-sm text-gray-300 cursor-pointer">
                <input
                  type="radio"
                  name="category"
                  value="{{ $category->id }}"
                  onchange="this.form.submit()"
                  class="w-4 h-4 accent-indigo-500 shrink-0"
                  {{ request('category') == $category->id ? 'checked' : '' }}>
                <span>{{ $category->name }}</span>
              </label>
            </li>
            @endforeach
          </ul>
        </form>
      </div>

      {{-- PRICE + BRANDS --}}
      <div class="filter-box p-6">
        <h3 class="text-white font-bold mb-4">Price Range</h3>

        <form action="{{ route('shop') }}" method="GET">

          {{-- preserve category + brands when applying price --}}
          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
          @foreach(request('brands', []) as $b)
            <input type="hidden" name="brands[]" value="{{ $b }}">
          @endforeach
          @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
          @endif

          <div class="space-y-3">
            <input
              type="number"
              name="min_price"
              placeholder="Min Price"
              value="{{ request('min_price') }}"
              class="w-full input-dark rounded-lg p-2.5 text-sm">

            <input
              type="number"
              name="max_price"
              placeholder="Max Price"
              value="{{ request('max_price') }}"
              class="w-full input-dark rounded-lg p-2.5 text-sm">
          </div>

          <button type="submit" class="mt-4 w-full bg-indigo-600 hover:bg-indigo-500 rounded-lg py-2.5 text-white text-sm font-semibold transition">
            Apply Filter
          </button>

          <p class="text-gray-500 text-xs mt-3">PKR 0 - 50,000</p>

         w

          <ul class="space-y-3">
            @foreach($brands as $brand)
            <li>
              <label class="flex items-center gap-3 text-sm text-gray-300 cursor-pointer">
                <input
                  type="checkbox"
                  name="brands[]"
                  value="{{ $brand->id }}"
                  onchange="this.form.submit()"
                  class="w-4 h-4 accent-indigo-500 shrink-0 rounded"
                  {{ in_array($brand->id, request('brands',[])) ? 'checked' : '' }}>
                <span>{{ $brand->name }}</span>
              </label>
            </li>
            @endforeach
          </ul>
        </form>
      </div>

    </div>

    {{-- PRODUCTS --}}
    <div class="lg:col-span-3">

      @if($products->count() > 0)

        {{-- GRID --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

          @foreach($products as $product)
          <div class="product-card group">

            <a href="{{ route('product.details', $product->id) }}" class="block h-52 overflow-hidden">
<picture>
    @if($product->image)
        <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $product->image)) }}" type="image/webp">
    @endif
    <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/400' }}"
         alt="{{ $product->name }}"
         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
</picture>
</a>

            <div class="p-5">

              <h3 class="text-white font-bold">{{ $product->name }}</h3>
              <p class="text-gray-500 text-xs mt-1">Premium Collection</p>

              <div class="flex justify-between items-center mt-4">
                <span class="text-indigo-400 font-black">Rs {{ number_format($product->new_price) }}</span>
                <span class="text-yellow-400 text-xs">★★★★★</span>
              </div>

              <div class="flex gap-2 mt-4">

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form flex-1">
                  @csrf
                  <button type="submit" class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition">
                    Add to Cart
                  </button>
                </form>

                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="add-to-wishlist-form">
                  @csrf
                  <button type="submit"
                          class="wishlist-btn w-11 h-11 rounded-xl bg-[#1c2233] border border-white/10 flex items-center justify-center text-gray-300 hover:bg-pink-600 hover:text-white hover:border-pink-500 transition-colors duration-300">
                    <i class="fa-regular fa-heart text-sm"></i>
                  </button>
                </form>

              </div>

            </div>
          </div>
          @endforeach

        </div>

        {{-- PAGINATION --}}
        <div class="mt-12">
          {{ $products->links() }}
        </div>

      @else

        {{-- EMPTY STATE / NO RESULTS --}}
        <div class="filter-box flex flex-col items-center justify-center text-center py-20 px-6">

          <div class="empty-icon w-20 h-20 rounded-full bg-indigo-500/10 flex items-center justify-center mb-6">
            <i class="fa-solid fa-magnifying-glass text-3xl text-indigo-400"></i>
          </div>

          <h3 class="text-white text-xl font-bold mb-2">
            @if(request('search'))
              No products found
            @else
              No products available
            @endif
          </h3>

          <p class="text-gray-500 text-sm max-w-sm">
            @if(request('search'))
              Sorry, we couldn't find anything matching
              "<span class="text-indigo-400">{{ request('search') }}</span>".
              Try a different keyword or check the spelling.
            @else
              There are no products to show right now. Please check back later.
            @endif
          </p>

          @if(request('search'))
            <a href="{{ route('shop') }}"
               class="mt-6 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold transition">
              Clear Search
            </a>
          @endif

        </div>

      @endif

    </div>
  </div>

</div>
</div>

<div id="cart-toast" class="fixed bottom-6 right-6 z-50 hidden">
  <div class="bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-semibold">
    <i class="fa-solid fa-check"></i>
    <span id="cart-toast-text">Added to cart!</span>
  </div>
</div>

<script>
document.addEventListener('submit', function (e) {
  const form = e.target;

  // ADD TO CART
  if (form.classList.contains('add-to-cart-form')) {
    e.preventDefault();

    const button = form.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = 'Adding...';

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
      },
      body: new FormData(form)
    })
      .then(res => res.json())
      .then(data => {
        button.innerHTML = originalText;
        button.disabled = false;

        const toast = document.getElementById('cart-toast');
        const toastText = document.getElementById('cart-toast-text');
        toastText.textContent = data.message || 'Added to cart!';
        toast.classList.remove('hidden');

        setTimeout(() => toast.classList.add('hidden'), 2000);
      })
      .catch(() => {
        button.innerHTML = originalText;
        button.disabled = false;
      });
  }

  // ADD TO WISHLIST
  if (form.classList.contains('add-to-wishlist-form')) {
    e.preventDefault();

    const button = form.querySelector('.wishlist-btn');
    const icon = button.querySelector('i');

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
      },
      body: new FormData(form)
    })
      .then(res => res.json())
      .then(data => {
        button.classList.add('heartbeat', 'bg-pink-600', 'text-white', 'border-pink-500');
        icon.classList.remove('fa-regular');
        icon.classList.add('fa-solid');

        const toast = document.getElementById('cart-toast');
        const toastText = document.getElementById('cart-toast-text');
        toastText.textContent = data.message || 'Added to wishlist!';
        toast.classList.remove('hidden');

        setTimeout(() => {
          toast.classList.add('hidden');
          button.classList.remove('heartbeat');
        }, 2000);
      })
      .catch(() => {});
  }
});
</script>

@endsection
