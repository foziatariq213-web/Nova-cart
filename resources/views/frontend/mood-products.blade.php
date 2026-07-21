@extends('layouts.app')

@section('title', ($mood->name ?? 'Mood') . ' Products')

@section('content')

<style>
.mood-results-bg {
    min-height: 100vh;
    background: radial-gradient(circle at top right, #7c3aed 0%, transparent 35%),
                radial-gradient(circle at bottom left, #ec4899 0%, transparent 35%),
                #090b10;
    position: relative;
    overflow: hidden;
    padding-top: 80px;
}

#particle-canvas {
    position: absolute;
    inset: 0;
    z-index: 0;
    pointer-events: none;
}

.floating {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.18;
    animation: float 8s infinite alternate;
    pointer-events: none;
}
.one { width: 300px; height: 300px; background: #8b5cf6; top: -80px; right: -80px; }
.two { width: 260px; height: 260px; background: #ec4899; left: -60px; top: 220px; }
.three { width: 220px; height: 220px; background: #6366f1; bottom: 40px; right: 30%; }
@keyframes float {
    100% { transform: translateY(40px) translateX(30px); }
}

/* Product Card */
.product-card {
    background: linear-gradient(180deg, rgba(26, 22, 42, 0.92), rgba(15, 16, 24, 0.96));
    backdrop-filter: blur(24px);
    border-radius: 1.5rem;
    border: 1px solid rgba(255,255,255,0.06);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px);
    border-color: rgba(139,92,246,0.3);
    box-shadow: 0 20px 60px -20px rgba(124,58,237,0.4);
}

.product-card .card-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    opacity: 0.1;
    transition: opacity 0.4s ease;
}

.product-card:hover .card-glow {
    opacity: 0.2;
}

.product-card .card-glow-a {
    width: 150px; height: 150px; background: #7c3aed;
    top: -50px; right: -50px;
}
.product-card .card-glow-b {
    width: 120px; height: 120px; background: #ec4899;
    bottom: -40px; left: -40px;
}

.product-image-wrap {
    position: relative;
    overflow: hidden;
    padding-top: 100%;
    background: rgba(0,0,0,0.3);
}

.product-image-wrap img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card:hover .product-image-wrap img {
    transform: scale(1.05);
}

.product-actions {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 2;
}

.product-actions button {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(10px);
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.product-actions button:hover {
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    border-color: transparent;
    transform: scale(1.1);
}

.product-actions button.wishlisted {
    background: linear-gradient(135deg, #ec4899, #7c3aed);
    border-color: transparent;
    color: white;
}

.product-info {
    padding: 16px 18px 18px;
}

.product-info h4 {
    font-size: 15px;
    font-weight: 700;
    color: white;
    margin: 8px 0 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 44px;
}

.product-info .price-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.product-info .price-row .current-price {
    font-size: 20px;
    font-weight: 700;
    color: white;
}

.btn-add-cart {
    width: 100%;
    padding: 10px;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #7c3aed, #6366f1);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-add-cart:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px -8px rgba(124,58,237,0.6);
}

.btn-add-cart.added {
    background: #10b981;
}

.btn-add-cart:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Toast Notification */
.toast-notification {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    padding: 14px 24px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    animation: slideUpToast 0.5s ease;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    backdrop-filter: blur(10px);
    max-width: 400px;
}

.toast-notification.success {
    background: rgba(16, 185, 129, 0.95);
    color: white;
    border: 1px solid rgba(255,255,255,0.1);
}

.toast-notification.error {
    background: rgba(239, 68, 68, 0.95);
    color: white;
    border: 1px solid rgba(255,255,255,0.1);
}

.toast-notification.wishlist {
    background: rgba(236, 72, 153, 0.95);
    color: white;
    border: 1px solid rgba(255,255,255,0.1);
}

@keyframes slideUpToast {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.toast-notification.hide {
    animation: slideDownToast 0.5s ease forwards;
}

@keyframes slideDownToast {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(30px); }
}

/* No results */
.no-results {
    text-align: center;
    padding: 60px 20px;
}

.no-results .icon {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.no-results h3 {
    color: white;
    font-size: 24px;
    margin-bottom: 8px;
}

.no-results p {
    color: #9ca3af;
    margin-bottom: 20px;
}

.btn-back {
    display: inline-block;
    padding: 10px 30px;
    border-radius: 50px;
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    color: white;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-back:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px -8px rgba(124,58,237,0.6);
}

.breadcrumb-custom {
    color: #9ca3af;
    font-size: 13px;
}

.breadcrumb-custom span { color: white; }

.breadcrumb-custom a {
    color: #a78bfa;
    text-decoration: none;
}

.breadcrumb-custom a:hover { text-decoration: underline; }

/* Spinner */
.spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
}
.pagination .page-item .page-link {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    color: #9ca3af;
    border-radius: 8px;
    padding: 8px 14px;
    transition: all 0.3s ease;
}
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    border-color: transparent;
    color: white;
}
.pagination .page-item .page-link:hover {
    background: rgba(255,255,255,0.12);
    color: white;
}
.pagination .page-item.disabled .page-link { opacity: 0.3; }
</style>

<div class="mood-results-bg py-12">

    <canvas id="particle-canvas"></canvas>

    <div class="floating one"></div>
    <div class="floating two"></div>
    <div class="floating three"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        {{-- Header --}}
        <div class="mb-8">
            <div class="breadcrumb-custom mb-2">
                <a href="{{ route('mood.shop') }}">← Back to Mood Shop</a>
            </div>
            <h2 class="text-3xl font-black text-white">
                {{ $mood->icon ?? '✨' }} {{ $mood->name ?? 'Mood' }} Products
            </h2>
            <p class="text-gray-400 text-sm mt-1">
                Found <span class="text-purple-400 font-bold">{{ $products->total() }}</span> products for this mood
            </p>
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">

                @foreach($products as $product)

                    <div class="product-card" data-product-id="{{ $product->id }}">

                        <div class="card-glow card-glow-a"></div>
                        <div class="card-glow card-glow-b"></div>

                        {{-- Image --}}
                        <div class="product-image-wrap">
    <a href="{{ route('product.details', $product->id) }}">
        <picture>
            @if($product->image)
                <source srcset="{{ asset(preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $product->image)) }}" type="image/webp">
            @endif
            <img src="{{ $product->image ? asset($product->image) : asset('images/no-image.png') }}"
                 alt="{{ $product->name }}" loading="lazy">
        </picture>
    </a>

                            {{-- Action Buttons --}}
                            <div class="product-actions">
                                <button class="wishlist-btn" onclick="toggleWishlist(this, {{ $product->id }})" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                                <button onclick="quickView({{ $product->id }})" title="Quick View">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="product-info">
                            <h4>{{ $product->name }}</h4>

                            <div class="price-row">
                                <span class="current-price">Rs. {{ number_format($product->new_price, 0) }}</span>
                            </div>

                            {{-- Add to Cart --}}
                            <button class="btn-add-cart" onclick="addToCart({{ $product->id }}, this)">
                                <i class="fa-solid fa-cart-plus"></i>
                                Add to Cart
                            </button>
                        </div>

                    </div>

                @endforeach

            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>

        @else

            {{-- No Results --}}
            <div class="no-results">
                <div class="icon">{{ $mood->icon ?? '✨' }}</div>
                <h3>No Products Found</h3>
                <p>There are no products available for this mood right now.</p>
                <a href="{{ route('mood.shop') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Back to Mood Shop
                </a>
            </div>

        @endif

    </div>

</div>

<script>
// ===================== PARTICLE BACKGROUND =====================
(function () {
    const canvas = document.getElementById('particle-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let particles = [];

    function resize() {
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    }

    function init() {
        resize();
        particles = [];
        const count = Math.min(60, Math.floor((canvas.width * canvas.height) / 18000));
        for (let i = 0; i < count; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                r: Math.random() * 1.8 + 0.6,
                vx: (Math.random() - 0.5) * 0.25,
                vy: (Math.random() - 0.5) * 0.25,
                a: Math.random() * 0.5 + 0.2
            });
        }
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0 || p.x > canvas.width) p.vx *= -1;
            if (p.y < 0 || p.y > canvas.height) p.vy *= -1;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(180, 150, 255, ${p.a})`;
            ctx.fill();
        });
        requestAnimationFrame(animate);
    }

    window.addEventListener('resize', init);
    init();
    animate();
})();

// ===================== TOAST NOTIFICATION =====================
function showToast(message, type = 'success') {
    const existing = document.querySelector('.toast-notification');
    if (existing) {
        existing.classList.add('hide');
        setTimeout(() => existing.remove(), 500);
    }

    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.innerHTML = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

// ===================== ADD TO CART =====================
function addToCart(productId, button) {
    button.disabled = true;
    button.innerHTML = '<span class="spinner"></span> Adding...';

    fetch('{{ url("cart/add") }}/' + productId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.innerHTML = '<i class="fa-solid fa-check"></i> Added!';
            button.classList.add('added');
            showToast('✅ ' + data.message, 'success');
            updateCartCount();
        } else {
            button.innerHTML = '<i class="fa-solid fa-cart-plus"></i> Add to Cart';
            button.disabled = false;
            showToast('❌ ' + data.message, 'error');
        }
    })
    .catch(error => {
        button.innerHTML = '<i class="fa-solid fa-cart-plus"></i> Add to Cart';
        button.disabled = false;
        showToast('❌ Something went wrong', 'error');
    });
}

// ===================== WISHLIST =====================
function toggleWishlist(button, productId) {
    const icon = button.querySelector('i');

    fetch('{{ url("wishlist/toggle") }}/' + productId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.added) {
                icon.className = 'fa-solid fa-heart';
                button.classList.add('wishlisted');
                showToast('❤️ Added to Wishlist!', 'wishlist');
            } else {
                icon.className = 'fa-regular fa-heart';
                button.classList.remove('wishlisted');
                showToast('💔 Removed from Wishlist', 'error');
            }
        } else {
            if (data.message === 'Please login first') {
                showToast('🔐 Please login to add to wishlist', 'error');
            } else {
                showToast('❌ ' + data.message, 'error');
            }
        }
    })
    .catch(error => {
        showToast('❌ Something went wrong', 'error');
    });
}

// ===================== QUICK VIEW =====================
function quickView(productId) {
    window.location.href = '{{ url("product") }}/' + productId;
}

// ===================== UPDATE CART COUNT =====================
function updateCartCount() {
    fetch('{{ url("cart/count") }}')
        .then(response => response.json())
        .then(data => {
            const countElements = document.querySelectorAll('.cart-count');
            countElements.forEach(el => {
                el.textContent = data.count;
            });
        })
        .catch(error => console.error('Error updating cart count:', error));
}
</script>

@endsection