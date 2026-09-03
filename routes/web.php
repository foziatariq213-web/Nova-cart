<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\GiftFinderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\StripeWebhookController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| STRIPE WEBHOOK (server-to-server — no auth, no CSRF)
|--------------------------------------------------------------------------
| Stripe's servers call this endpoint directly, so it can't be behind the
| auth middleware. It is authenticated by the Stripe-Signature header
| (verified in the controller) and excluded from CSRF in bootstrap/app.php.
*/

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

});

/*
|--------------------------------------------------------------------------
| AUTH USER ROUTES (FRONTEND)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // HOME
    Route::get('/home', function () {
        $products = Product::with('category', 'brand')->latest()->take(12)->get();
        return view('frontend.home', compact('products'));
    })->name('home');

    // SHOP
   
        Route::get('/shop', function () {

    $query = Product::query();

    // Search by Product Name Only
    if (request()->filled('search')) {
        $query->where('name', 'LIKE', '%' . request('search') . '%');
    }

    // Category Filter
    if (request('category')) {
        $query->where('category_id', request('category'));
    }

    // Brand Filter
    if (request('brands')) {
        $query->whereIn('brand_id', request('brands'));
    }

    // Price Filter
    if (request('min_price')) {
        $query->where('new_price', '>=', request('min_price'));
    }

    if (request('max_price')) {
        $query->where('new_price', '<=', request('max_price'));
    }

    $products = $query->latest()->paginate(12)->withQueryString();

    $categories = Category::all();
    $brands = Brand::all();

    return view('frontend.shop', compact(
        'products',
        'categories',
        'brands'
    ));

})->name('shop');
        

      

    Route::get('/product/{product}', function (Product $product) {
        return view('frontend.product-details', compact('product'));
    })->name('product.details');

    Route::get('/categories', function () {
        $categories = Category::withCount('products')->get();
        return view('frontend.categories', compact('categories'));
    })->name('categories');

    // MOOD SHOP
    Route::get('/mood-shop', [MoodController::class, 'index'])->name('mood.shop');
    Route::get('/mood-shop/{mood}', [MoodController::class, 'products'])->name('mood.products');

    // GIFT FINDER
    Route::get('/gift-finder', [GiftFinderController::class, 'index'])->name('gift.finder');
    Route::post('/gift-finder', [GiftFinderController::class, 'search'])->name('gift.search');

    // CART
    Route::get('/cart', function () {
        return view('frontend.cart');
    })->name('cart');

    // ==========================================
    // CONTACT ROUTES (FIXED)
    // ==========================================
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

    // ==========================================
    // WISHLIST
    // ==========================================

    Route::get('/wishlist', function () {
        $wishlist = session()->get('wishlist', []);
        return view('frontend.wishlist', compact('wishlist'));
    })->name('wishlist');

    Route::post('/wishlist/add/{id}', function (Request $request, $id) {
        $product = Product::findOrFail($id);
        $wishlist = session()->get('wishlist', []);

        if (!isset($wishlist[$id])) {
            $wishlist[$id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->new_price,
                'image' => $product->image,
            ];
        }

        session()->put('wishlist', $wishlist);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to wishlist',
                'wishlist_count' => count($wishlist),
            ]);
        }

        return back()->with('success', 'Product added to wishlist.');
    })->name('wishlist.add');

    Route::post('/wishlist/remove/{id}', function (Request $request, $id) {
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from wishlist',
                'wishlist_count' => count($wishlist),
            ]);
        }

        return back()->with('success', 'Product removed from wishlist.');
    })->name('wishlist.remove');

    // ==========================================
    // WISHLIST TOGGLE (used by gift-results.blade.php)
    // ==========================================
    Route::post('/wishlist/toggle/{id}', function ($id) {
        $product = Product::findOrFail($id);
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);

            return response()->json([
                'success' => true,
                'added'   => false,
                'message' => 'Product removed from wishlist',
            ]);
        } else {
            $wishlist[$id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->new_price,
                'image' => $product->image,
            ];
            session()->put('wishlist', $wishlist);

            return response()->json([
                'success' => true,
                'added'   => true,
                'message' => 'Product added to wishlist',
            ]);
        }
    })->name('wishlist.toggle');

    // ==========================================
    // CART COUNT (used by updateCartCount() in JS)
    // ==========================================
    Route::get('/cart/count', function () {
        $cart = session()->get('cart', []);
        return response()->json([
            'count' => count($cart),
        ]);
    })->name('cart.count');

    // ==========================================
    // CHECKOUT
    // ==========================================

    Route::get('/checkout', function () {
        $cartItems = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item['new_price'] * $item['quantity'];
        }

        return view('frontend.checkout', compact('cartItems', 'subtotal'));
    })->name('checkout');

    Route::post('/checkout', function (Request $request) {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.',
                ], 422);
            }
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'payment_method' => 'required|string|in:Cash on Delivery,Credit Card',
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['new_price'] * $item['quantity'];
        }

        $orderNumber = 'ORD-' . str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $fullAddress = $request->address . ', ' . $request->city . ' - ' . $request->postal_code;

        $isCod = $request->payment_method === 'Cash on Delivery';
        $isCard = $request->payment_method === 'Credit Card';

        // COD is collected on delivery; card orders stay Unpaid until Stripe
        // confirms the charge (webhook / return page marks them Paid).
        $paymentStatus = $isCod ? 'Pending' : 'Unpaid';

        $itemsData = [];
        foreach ($cart as $id => $item) {
            $itemsData[] = [
                'id' => $id,
                'name' => $item['name'],
                'price' => $item['new_price'],
                'qty' => $item['quantity'],
                'image' => $item['image'] ?? null,
            ];
        }

        $order = Order::create([
            'user_id'        => auth()->id(),
            'order_number'   => $orderNumber,
            'customer_name'  => $request->name,
            'email'          => auth()->user()->email,
            'phone'          => $request->phone,
            'address'        => $fullAddress,
            'city'           => $request->city,
            'postal_code'    => $request->postal_code,
            'total'          => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => $paymentStatus,
            'order_status'   => 'Pending',
            'items'          => $itemsData,
        ]);

        $customer = Customer::where('email', auth()->user()->email)->first();

        if ($customer) {
            $customer->increment('total_orders');
            $customer->increment('total_spent', $total);

            $customer->update([
                'phone'   => $request->phone,
                'address' => $fullAddress,
            ]);
        } else {
            Customer::create([
                'name'         => $request->name,
                'email'        => auth()->user()->email,
                'phone'        => $request->phone,
                'address'      => $fullAddress,
                'total_orders' => 1,
                'total_spent'  => $total,
                'status'       => 'Active',
            ]);
        }

        session()->forget('cart');

        // Card orders: hand over to the secure Stripe payment page
        // instead of finishing the checkout here.
        if ($isCard) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success'      => true,
                    'message'      => 'Order created. Redirecting to secure payment…',
                    'order_number' => $order->order_number,
                    'redirect_url' => route('checkout.stripe.pay', $order),
                ]);
            }

            return redirect()->route('checkout.stripe.pay', $order);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'      => true,
                'message'      => 'Order placed successfully.',
                'order_number' => $order->order_number,
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    })->name('checkout.store');

    // ==========================================
    // STRIPE PAYMENT (card orders)
    // ==========================================

    Route::get('/checkout/pay/{order}', [StripePaymentController::class, 'pay'])->name('checkout.stripe.pay');
    Route::get('/checkout/stripe/return', [StripePaymentController::class, 'handleReturn'])->name('checkout.stripe.return');

    // ==========================================
    // ORDER ROUTES
    // ==========================================

    Route::get('/orders', function () {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('frontend.orders', compact('orders'));
    })->name('orders.index');

    Route::post('/orders/{order}/cancel', function (Order $order) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $status = strtolower($order->order_status ?? 'pending');

        if (in_array($status, ['cancelled', 'delivered'])) {
            return back()->with('error', 'This order cannot be cancelled. It is already ' . $status . '.');
        }

        if ($order->created_at->diffInDays(now()) >= 3) {
            return back()->with('error', 'You cannot cancel this order now! The 3-day cancellation period has expired.');
        }

        $order->update([
            'order_status' => 'Cancelled',
            'payment_status' => 'Unpaid',
        ]);

        return back()->with('success', 'Order #' . $order->order_number . ' has been cancelled successfully.');
    })->name('orders.cancel');

    Route::delete('/orders/{order}/delete', function (Order $order) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $status = strtolower($order->order_status ?? 'pending');

        if ($status !== 'cancelled') {
            return back()->with('error', 'Only cancelled orders can be deleted.');
        }

        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order #' . $orderNumber . ' has been deleted permanently.');
    })->name('orders.delete');

    Route::get('/orders/{order}', function (Order $order) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('frontend.order-details', compact('order'));
    })->name('orders.show');

    // ==========================================
    // STATIC PAGES (Contact removed - already above)
    // ==========================================
    Route::view('/about', 'frontend.about')->name('about');
    Route::view('/privacy-policy', 'frontend.privacy')->name('privacy');
    Route::view('/terms-conditions', 'frontend.terms')->name('terms');

    // ==========================================
    // AJAX CART ROUTES
    // ==========================================

    Route::post('/cart/add/{id}', function (Request $request, $id) {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'new_price' => $product->new_price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => 'Product added to cart successfully',
                'cart_count' => count($cart),
            ]);
        }

        return back()->with('success', 'Product added to cart.');
    })->name('cart.add');

    Route::post('/cart/update/{id}', function (Request $request, $id) {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $quantity = max(1, (int) $request->quantity);
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated successfully.');
    })->name('cart.update');

    Route::post('/cart/remove/{id}', function ($id) {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed from cart.');
    })->name('cart.remove');

    Route::post('/cart/clear', function () {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully.');
    })->name('cart.clear');

});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            $products = Product::count();
            $orders = Order::count();
            $customers = Customer::count();
            $revenue = Order::where('payment_status', 'Paid')->sum('total');

            return view('admin.dashboard', compact('products', 'orders', 'customers', 'revenue'));
        })->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
       Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
Route::delete('/orders/{order}', [OrderController::class, 'adminDestroy'])->name('orders.destroy');
        Route::resource('customers', CustomerController::class)->only(['index', 'show', 'destroy']);
    });

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');