@extends('layouts.app')

@section('title', 'Privacy Policy | NovaCart')

@section('content')

<section class="relative py-20">

    <div class="max-w-6xl mx-auto px-6">

        <!-- Hero -->
        <div class="text-center mb-14">

            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-indigo-600/20 border border-indigo-500/30 text-indigo-300 text-sm mb-5">

                <i class="fa-solid fa-shield-halved"></i>

                Privacy Policy

            </div>

            <h1 class="text-5xl font-extrabold text-white heading-font">

                Your Privacy Matters

            </h1>

            <p class="text-gray-400 mt-5 max-w-3xl mx-auto leading-8">

                NovaCart respects your privacy and is committed to protecting
                your personal information. This page explains how we collect,
                use and safeguard your information while using our website.

            </p>

        </div>

        <!-- Card -->

        <div class="bg-[#23252c] border border-white/10 rounded-3xl p-10 shadow-2xl space-y-10">        <!-- Information Collection -->

        <div>

            <div class="flex items-center gap-3 mb-4">

                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center">

                    <i class="fa-solid fa-database text-white"></i>

                </div>

                <h2 class="text-2xl font-bold text-white">
                    Information We Collect
                </h2>

            </div>

            <p class="text-gray-400 leading-8">

                We may collect information such as your name, email address,
                phone number, shipping address and payment details whenever
                you register, place an order or contact our support team.

            </p>

        </div>

        <!-- How We Use -->

        <div>

            <div class="flex items-center gap-3 mb-4">

                <div class="w-12 h-12 rounded-xl bg-green-600 flex items-center justify-center">

                    <i class="fa-solid fa-user-check text-white"></i>

                </div>

                <h2 class="text-2xl font-bold text-white">
                    How We Use Your Information
                </h2>

            </div>

            <ul class="space-y-3 text-gray-400 leading-8 list-disc ml-6">

                <li>Process and deliver your orders.</li>

                <li>Improve your shopping experience.</li>

                <li>Provide customer support.</li>

                <li>Send important order updates.</li>

                <li>Improve website security and performance.</li>

            </ul>

        </div>

        <!-- Data Security -->

        <div>

            <div class="flex items-center gap-3 mb-4">

                <div class="w-12 h-12 rounded-xl bg-red-600 flex items-center justify-center">

                    <i class="fa-solid fa-lock text-white"></i>

                </div>

                <h2 class="text-2xl font-bold text-white">
                    Data Security
                </h2>

            </div>

            <p class="text-gray-400 leading-8">

                We use secure technologies and industry standard practices to
                protect your personal information from unauthorized access,
                misuse or disclosure.

            </p>

        </div>

        <!-- Cookies -->

        <div>

            <div class="flex items-center gap-3 mb-4">

                <div class="w-12 h-12 rounded-xl bg-yellow-500 flex items-center justify-center">

                    <i class="fa-solid fa-cookie-bite text-white"></i>

                </div>

                <h2 class="text-2xl font-bold text-white">
                    Cookies
                </h2>

            </div>

            <p class="text-gray-400 leading-8">

                Cookies help us remember your preferences, improve website
                performance and provide a better shopping experience.

            </p>

        </div>        <!-- Policy Updates -->

        <div>

            <div class="flex items-center gap-3 mb-4">

                <div class="w-12 h-12 rounded-xl bg-purple-600 flex items-center justify-center">

                    <i class="fa-solid fa-arrows-rotate text-white"></i>

                </div>

                <h2 class="text-2xl font-bold text-white">
                    Policy Updates
                </h2>

            </div>

            <p class="text-gray-400 leading-8">

                NovaCart may update this Privacy Policy from time to time to
                reflect changes in our services, technology or legal
                requirements. Any updates will be published on this page.

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

                If you have any questions regarding this Privacy Policy,
                please contact our support team. We will be happy to assist
                you with any privacy-related concerns.

            </p>

        </div>

        <!-- Footer -->

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

</section>

@endsection