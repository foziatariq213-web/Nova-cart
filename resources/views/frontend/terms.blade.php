@extends('layouts.app')

@section('title', 'Terms & Conditions | NovaCart')

@section('content')

<section class="relative py-20">

    <div class="max-w-6xl mx-auto px-6">

        <!-- Hero -->

        <div class="text-center mb-14">

            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-indigo-600/20 border border-indigo-500/30 text-indigo-300 text-sm mb-5">

                <i class="fa-solid fa-file-contract"></i>

                Terms & Conditions

            </div>

            <h1 class="text-5xl font-extrabold text-white heading-font">

                Terms of Service

            </h1>

            <p class="text-gray-400 mt-5 max-w-3xl mx-auto leading-8">

                Welcome to NovaCart. By accessing or using our website,
                you agree to follow these Terms & Conditions. Please read
                them carefully before using our services.

            </p>

        </div>

        <!-- Card -->

        <div class="bg-[#23252c] border border-white/10 rounded-3xl p-10 shadow-2xl space-y-10">

            <!-- Acceptance -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center">

                        <i class="fa-solid fa-check text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">

                        Acceptance of Terms

                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    By using NovaCart, you agree to comply with these Terms
                    & Conditions. If you do not agree, please discontinue
                    using our website and services.

                </p>

            </div>

            <!-- User Account -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-green-600 flex items-center justify-center">

                        <i class="fa-solid fa-user-shield text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">

                        User Accounts

                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    You are responsible for maintaining the confidentiality
                    of your account credentials and for all activities
                    performed under your account.

                </p>

            </div>            <!-- Orders -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center">

                        <i class="fa-solid fa-cart-shopping text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">
                        Orders
                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    All orders placed through NovaCart are subject to
                    product availability and order confirmation. We reserve
                    the right to cancel or refuse any order if necessary.

                </p>

            </div>

            <!-- Payments -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-yellow-500 flex items-center justify-center">

                        <i class="fa-solid fa-credit-card text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">
                        Payments
                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    Customers must provide valid payment information.
                    Payments are processed securely using trusted payment
                    methods. NovaCart does not store sensitive payment
                    details.

                </p>

            </div>

            <!-- Shipping -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-cyan-600 flex items-center justify-center">

                        <i class="fa-solid fa-truck-fast text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">
                        Shipping & Delivery
                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    Delivery times may vary depending on your location.
                    While we aim to deliver orders promptly, unexpected
                    delays may occur due to weather, logistics or other
                    circumstances beyond our control.

                </p>

            </div>

            <!-- Returns -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-red-600 flex items-center justify-center">

                        <i class="fa-solid fa-rotate-left text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">
                        Returns & Refunds
                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    Eligible products may be returned within our return
                    policy period. Refunds are processed after inspection
                    and approval of the returned items.

                </p>

            </div>

            <!-- Product Availability -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-violet-600 flex items-center justify-center">

                        <i class="fa-solid fa-box-open text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">
                        Product Availability
                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    We strive to keep product information accurate.
                    However, product availability, prices and descriptions
                    may change without prior notice.

                </p>

            </div>            <!-- Intellectual Property -->

           

    

            <!-- Limitation of Liability -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center">

                        <i class="fa-solid fa-triangle-exclamation text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">
                        Limitation of Liability
                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    NovaCart shall not be liable for any indirect,
                    incidental or consequential damages arising from the use
                    of this website, including service interruptions or data
                    loss.

                </p>

            </div>

            <!-- Changes -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center">

                        <i class="fa-solid fa-pen-to-square text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">
                        Changes to These Terms
                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    We reserve the right to modify or update these Terms &
                    Conditions at any time. Updated versions will be posted
                    on this page and become effective immediately after
                    publication.

                </p>

            </div>

            <!-- Contact -->

            <div>

                <div class="flex items-center gap-3 mb-4">

                    <div class="w-12 h-12 rounded-xl bg-cyan-600 flex items-center justify-center">

                        <i class="fa-solid fa-envelope text-white"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-white">
                        Contact Us
                    </h2>

                </div>

                <p class="text-gray-400 leading-8">

                    If you have any questions regarding these Terms &
                    Conditions, please contact our customer support team.
                    We are always happy to assist you.

                </p>

            </div>

            <!-- Bottom -->

            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-5">

                <p class="text-gray-500 text-sm">

                    Last Updated: {{ date('F d, Y') }}

                </p>

                <a href="{{ route('home') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold transition duration-300">

                    <i class="fa-solid fa-house mr-2"></i>

                    Back to Home

                </a>

            </div>

        </div>

    </div>

</section>

@endsection