<nav x-data="{ open: false, profile: false, scrolled: false, searchFocused: false, searchHover: false }"
     x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
     class="sticky top-0 z-50 bg-[#1b1c22]/90 backdrop-blur-xl border-b border-gray-800 transition-shadow duration-300"
     :class="scrolled ? 'shadow-[0_8px_30px_rgba(0,0,0,.45)]' : 'shadow-[0_8px_30px_rgba(0,0,0,.35)]'">

    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="flex items-center justify-between h-20">

            <!-- ===== LOGO - UPDATED WITH SVG ===== -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">

                <!-- Logo Image -->
          

                <!-- Text Logo (Fallback / Additional) -->
                <div>
                    <h2 class="heading-font text-2xl font-extrabold text-white tracking-wide">
                        <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Nova</span>
                        <span class="text-white">Cart</span>
                    </h2>
                    <p class="text-[10px] text-gray-400 -mt-0.5 tracking-wider">Premium Shopping</p>
                </div>

            </a>

            @auth

                @if(auth()->user()->role == 'user')

                    <!-- ========================================== -->
                    <!-- PREMIUM SEARCH BAR WITH NEXT-LEVEL ANIMATIONS -->
                    <!-- ========================================== -->
                   <form action="{{ route('shop') }}" method="GET" class="hidden lg:flex flex-1 max-w-2xl mx-8">

    <div class="relative w-full group">

        <!-- Glow -->
        <div
            class="absolute -inset-[2px] rounded-full bg-gradient-to-r from-indigo-500 via-violet-500 to-pink-500 blur-xl opacity-0 transition duration-500"
            :class="searchFocused ? 'opacity-40' : 'group-hover:opacity-20'">
        </div>

        <!-- Search Box -->
        <div
            class="relative flex items-center h-14 rounded-full bg-[#181b23]/95 border border-gray-700 transition-all duration-300 overflow-hidden"
            :class="searchFocused
                ? 'border-indigo-500 shadow-[0_0_35px_rgba(99,102,241,.35)]'
                : 'hover:border-gray-500'">

            <!-- Search Icon -->
            <button type="submit"
                class="absolute left-5 text-gray-400 hover:text-indigo-400 transition">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <!-- Input -->
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                
                @focus="searchFocused = true"
                @blur="searchFocused = false"
                class="w-full h-full bg-transparent pl-14 pr-24 text-white placeholder-gray-500 focus:outline-none text-sm tracking-wide">

            <!-- Shortcut -->
            <div
                class="absolute right-4 flex items-center gap-2">

                @if(request('search'))
                    <a href="{{ route('shop') }}"
                       class="w-8 h-8 rounded-full bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </a>
                @else
                    
                @endif

            </div>

        </div>

    </div>

</form>
                            
                        

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center gap-4 flex-shrink-0">

                        <!-- Home -->
                        <a href="{{ route('home') }}" class="relative font-medium text-gray-300 hover:text-white transition duration-300 group whitespace-nowrap flex-shrink-0">
                            Home
                            <span class="absolute -bottom-2 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>

                        <!-- Shop -->
                        <a href="{{ route('shop') }}" class="relative font-medium text-gray-300 hover:text-white transition duration-300 group whitespace-nowrap flex-shrink-0">
                            Shop
                            <span class="absolute -bottom-2 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>

                        <!-- Mood Shop -->
                        <a href="{{ route('mood.shop') }}" class="relative font-medium text-gray-300 hover:text-white transition duration-300 group whitespace-nowrap flex-shrink-0">
                            Mood Shop
                            <span class="absolute -bottom-2 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>

                        <!-- Gift Finder -->
                        <a href="{{ route('gift.finder') }}" class="relative font-medium text-gray-300 hover:text-white transition duration-300 group whitespace-nowrap flex-shrink-0">
                            Gift Finder
                            <span class="absolute -bottom-2 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>

                        <!-- Contact -->
                        <a href="{{ route('contact') }}" class="relative font-medium text-gray-300 hover:text-white transition duration-300 group whitespace-nowrap flex-shrink-0">
                            Contact us
                            <span class="absolute -bottom-2 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>

                        <!-- My Orders -->
                        <a href="{{ Route::has('orders.index') ? route('orders.index') : '#' }}" class="relative font-medium text-gray-300 hover:text-white transition duration-300 group whitespace-nowrap flex-shrink-0">
                            My Orders
                            <span class="absolute -bottom-2 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>

                        <!-- Wishlist -->
                        <a href="{{ route('wishlist') }}" class="relative w-11 h-11 rounded-full bg-[#2a2c33] flex items-center justify-center text-gray-300 hover:text-pink-500 hover:bg-[#343741] hover:scale-110 transition duration-300 flex-shrink-0">
                            <i class="fa-regular fa-heart text-lg"></i>
                        </a>

                        <!-- Cart -->
                        <a href="{{ route('cart') }}" class="relative w-11 h-11 rounded-full bg-[#2a2c33] flex items-center justify-center text-gray-300 hover:text-white hover:bg-indigo-600 hover:scale-110 transition duration-300 flex-shrink-0">
                            <i class="fa-solid fa-cart-shopping text-lg"></i>
                            @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold animate-bounce">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative flex-shrink-0">

                            <button
                                @click="profile = !profile"
                                class="relative flex items-center gap-2.5 pl-2.5 pr-3 py-1.5 rounded-xl bg-[#22242c] hover:bg-[#2a2c35] border border-gray-800 hover:border-indigo-500/40 transition-all duration-300 group overflow-hidden whitespace-nowrap">

                                <span class="absolute inset-0 bg-gradient-to-r from-indigo-500/0 via-indigo-500/10 to-violet-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                                <span class="relative flex items-center justify-center w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 shadow-md shadow-indigo-900/40 group-hover:shadow-indigo-500/40 group-hover:scale-105 transition-all duration-300 flex-shrink-0">
                                    <i class="fa-solid fa-user text-sm text-white"></i>
                                    <span class="absolute -inset-0.5 rounded-lg bg-gradient-to-br from-indigo-400 to-violet-500 opacity-0 group-hover:opacity-30 blur-md transition-opacity duration-300"></span>
                                </span>

                                <span class="relative text-gray-200 group-hover:text-white text-sm font-medium transition-colors duration-300">{{ auth()->user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-gray-500 group-hover:text-indigo-400 transition-all duration-300" :class="profile ? 'rotate-180' : ''"></i>
                            </button>

                            <!-- Dropdown -->
                            <div
                                x-show="profile"
                                x-cloak
                                @click.away="profile = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-4 w-64 bg-[#26282f] border border-gray-700 rounded-2xl shadow-2xl overflow-hidden">

                                <!-- Header -->
                                <div class="px-5 py-4 border-b border-gray-700 bg-gradient-to-r from-indigo-600/20 to-violet-600/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-11 h-11 rounded-full bg-gradient-to-r from-indigo-500 to-violet-600 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-white"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-white font-semibold truncate">{{ auth()->user()->name }}</h4>
                                            <p class="text-gray-400 text-xs truncate">{{ auth()->user()->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu -->
                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-3 text-gray-300 hover:bg-indigo-600 hover:text-white hover:pl-6 transition-all duration-200">
                                        <span class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                                            <i class="fa-solid fa-user text-indigo-400"></i>
                                        </span>
                                        My Profile
                                    </a>
                                    <a href="{{ Route::has('orders.index') ? route('orders.index') : '#' }}" class="flex items-center gap-3 px-5 py-3 text-gray-300 hover:bg-indigo-600 hover:text-white hover:pl-6 transition-all duration-200">
                                        <span class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center">
                                            <i class="fa-solid fa-box text-amber-400"></i>
                                        </span>
                                        My Orders
                                    </a>
                                    <a href="{{ route('wishlist') }}" class="flex items-center gap-3 px-5 py-3 text-gray-300 hover:bg-indigo-600 hover:text-white hover:pl-6 transition-all duration-200">
                                        <span class="w-8 h-8 rounded-lg bg-pink-500/20 flex items-center justify-center">
                                            <i class="fa-solid fa-heart text-pink-400"></i>
                                        </span>
                                        Wishlist
                                    </a>
                                </div>

                                <div class="border-t border-gray-700"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="w-full flex items-center gap-3 px-5 py-3 text-red-400 hover:bg-red-600 hover:text-white transition duration-200">
                                        <span class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                        </span>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                    <!-- Mobile Button -->
                    <button
                        @click="open = !open"
                        class="md:hidden w-11 h-11 rounded-xl bg-[#2a2c33] hover:bg-indigo-600 transition duration-300 flex items-center justify-center text-white flex-shrink-0">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                @else

                    <!-- Admin Menu -->
                    <div class="hidden md:flex items-center gap-5">
                        <a href="{{ route('admin.dashboard') }}" class="font-medium text-gray-300 hover:text-white transition duration-300 whitespace-nowrap">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="font-medium text-gray-300 hover:text-white transition duration-300 whitespace-nowrap">Products</a>
                        <a href="{{ route('admin.orders.index') }}" class="font-medium text-gray-300 hover:text-white transition duration-300 whitespace-nowrap">Orders</a>
                        <a href="{{ route('admin.customers.index') }}" class="font-medium text-gray-300 hover:text-white transition duration-300 whitespace-nowrap">Customers</a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold shadow-lg transition duration-300 whitespace-nowrap">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                            </button>
                        </form>
                    </div>

                    <!-- Mobile Button -->
                    <button
                        @click="open = !open"
                        class="md:hidden w-11 h-11 rounded-xl bg-[#2a2c33] hover:bg-indigo-600 transition duration-300 flex items-center justify-center text-white">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                @endif

            @else

                <!-- Guest Menu -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('login') }}" class="font-medium text-gray-300 hover:text-white transition duration-300 whitespace-nowrap">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold shadow-lg hover:shadow-indigo-500/30 hover:scale-105 transition duration-300 whitespace-nowrap">Register</a>
                </div>

                <!-- Mobile Button -->
                <button
                    @click="open = !open"
                    class="md:hidden w-11 h-11 rounded-xl bg-[#2a2c33] hover:bg-indigo-600 transition duration-300 flex items-center justify-center text-white">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

            @endauth

        </div>
    </div>
</nav>

<style>
/* Slow spin animation for gradient border */
@keyframes spin-slow {
    from { transform: rotate(0deg); background-position: 0% 50%; }
    to { transform: rotate(360deg); background-position: 100% 50%; }
}
.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}

/* Shimmer text animation */
@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}
.animate-shimmer {
    animation: shimmer 3s ease-in-out infinite;
}

/* Floating particles */
@keyframes float-particle {
    0%, 100% { 
        transform: translate(0, 0) scale(0.5);
        opacity: 0.2;
    }
    25% { 
        transform: translate(15px, -20px) scale(1.2);
        opacity: 0.8;
    }
    50% { 
        transform: translate(-10px, -35px) scale(1);
        opacity: 0.5;
    }
    75% { 
        transform: translate(20px, -15px) scale(1.5);
        opacity: 0.9;
    }
}
.animate-float-particle {
    animation: float-particle 4s ease-in-out infinite;
}

/* Gradient move for progress bar */
@keyframes gradient-move {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>