<footer class="bg-[#121317] border-t border-gray-800 mt-20 text-gray-300">

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">

        <!-- Top Features -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-14">

            <div class="flex items-center gap-4 bg-[#1b1d23] rounded-2xl p-5 border border-gray-800 hover:border-indigo-500 transition">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-truck-fast text-white text-lg"></i>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm">Fast Delivery</h4>
                    <p class="text-gray-400 text-xs mt-1">Nationwide shipping</p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-[#1b1d23] rounded-2xl p-5 border border-gray-800 hover:border-indigo-500 transition">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-shield-halved text-white text-lg"></i>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm">Secure Payment</h4>
                    <p class="text-gray-400 text-xs mt-1">100% protected</p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-[#1b1d23] rounded-2xl p-5 border border-gray-800 hover:border-indigo-500 transition">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-rotate-left text-white text-lg"></i>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm">Easy Returns</h4>
                    <p class="text-gray-400 text-xs mt-1">Hassle free policy</p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-[#1b1d23] rounded-2xl p-5 border border-gray-800 hover:border-indigo-500 transition">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-headset text-white text-lg"></i>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm">24/7 Support</h4>
                    <p class="text-gray-400 text-xs mt-1">Dedicated help</p>
                </div>
            </div>

        </div>

        <!-- Main Footer -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            <!-- Column 1 -->
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fa-solid fa-cart-shopping text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white heading-font">NovaCart</h3>
                        <p class="text-xs text-indigo-400 tracking-widest uppercase">Premium Shopping</p>
                    </div>
                </div>

                <p class="text-gray-400 leading-7 text-sm">
                    NovaCart is your trusted online shopping destination where
                    you can discover premium products, secure payments,
                    fast delivery and an exceptional shopping experience.
                </p>
            </div>

            <!-- Customer Service -->
            <div>
                <h4 class="text-white text-lg font-semibold mb-6">Customer Service</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-indigo-400 transition">My Profile</a></li>
                    <li><a href="{{ Route::has('orders.index') ? route('orders.index') : '#' }}" class="hover:text-indigo-400 transition">My Orders</a></li>
                    <li><a href="{{ route('wishlist') }}" class="hover:text-indigo-400 transition">Wishlist</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-indigo-400 transition">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-indigo-400 transition">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-white text-lg font-semibold mb-6">Contact Us</h4>
                <div class="space-y-5">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-indigo-400 mt-1"></i>
                        <span class="text-gray-400">Lahore, Pakistan</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-phone text-indigo-400 mt-1"></i>
                        <span class="text-gray-400">+92 300 1234567</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-envelope text-indigo-400 mt-1"></i>
                        <span class="text-gray-400">support@novacart.com</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Divider -->
        <div class="border-t border-gray-800 my-10"></div>

        <!-- Bottom Section -->
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4 text-center lg:text-left">

            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} NovaCart. All rights reserved.
            </p>

            <div class="flex items-center gap-4 text-gray-500 text-sm">
                <a href="{{ route('privacy') }}" class="hover:text-indigo-400 transition">Privacy Policy</a>
                <span class="text-gray-700">|</span>
                <a href="{{ route('terms') }}" class="hover:text-indigo-400 transition">Terms & Conditions</a>
            </div>

        </div>

    </div>

</footer>