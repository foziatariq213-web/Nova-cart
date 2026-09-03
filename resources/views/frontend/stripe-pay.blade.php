@extends('layouts.app')
@section('content')

<style>
.checkout-bg {
    background: radial-gradient(circle at 50% 0%, #161920 0%, #0d0e12 100%);
    min-height: 100vh;
}
.checkout-card {
    background: #141518;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 1.5rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}
.gradient-btn {
    background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}
.gradient-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(99, 102, 241, 0.3);
    filter: brightness(1.1);
}
.gradient-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}
.custom-scroll::-webkit-scrollbar { width: 6px; }
.custom-scroll::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
.custom-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
</style>

<div class="checkout-bg py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- PAGE HEADER --}}
        <div class="mb-12 text-left backdrop-blur-sm p-2 rounded-xl inline-block">
            <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-credit-card text-indigo-500 text-3xl sm:text-4xl"></i> Secure Card Payment
            </h1>
            <p class="text-gray-400 mt-2 text-sm sm:text-base">
                Order <span class="text-indigo-400 font-mono font-bold">{{ $order->order_number }}</span>
                — complete your payment below. Powered by Stripe.
            </p>
        </div>

        {{-- FLASH ERROR --}}
        @if(session('error'))
            <div class="mb-8 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-400 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-12 gap-8 items-start">

            {{-- LEFT COLUMN: PAYMENT ELEMENT --}}
            <div class="lg:col-span-7">
                <div class="checkout-card p-6 sm:p-8">
                    <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-5">
                        <i class="fa-solid fa-shield-halved text-indigo-400 text-xl"></i>
                        <h3 class="text-white text-xl font-bold tracking-wide">Payment Details</h3>
                    </div>

                    <p class="text-gray-400 text-sm mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-[11px] text-indigo-400"></i>
                        Your card information is encrypted and handled directly by Stripe — it never touches our servers.
                    </p>

                    <div id="payment-message" class="hidden mb-4 rounded-xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-sm text-rose-400"></div>

                    <form id="payment-form">
                        <div id="payment-element">
                            <div class="py-10 text-center text-sm text-gray-400">
                                <i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Loading secure payment form&hellip;
                            </div>
                        </div>

                        <button id="submit-button" type="submit"
                                class="w-full gradient-btn mt-8 py-4 rounded-xl text-white font-bold shadow-lg tracking-wider text-sm sm:text-base flex items-center justify-center gap-2.5">
                            <span id="button-content" class="flex items-center justify-center gap-2">
                                <i class="fa-solid fa-lock text-xs"></i> Pay Rs {{ number_format($order->total) }}
                            </span>
                        </button>

                        <p class="mt-4 text-center text-xs text-gray-500 flex items-center justify-center gap-1.5">
                            <i class="fa-brands fa-stripe text-indigo-400 text-lg"></i> Secure payment by Stripe
                        </p>
                    </form>
                </div>

                <a href="{{ route('orders.index') }}" class="flex items-center justify-center gap-2 mt-6 text-center text-sm text-gray-400 hover:text-white transition duration-200 group">
                    <i class="fa-solid fa-arrow-left text-xs transform group-hover:-translate-x-1 transition-transform"></i> Back To My Orders
                </a>
            </div>

            {{-- RIGHT COLUMN: ORDER SUMMARY --}}
            <div class="lg:col-span-5">
                <div class="checkout-card p-6 sm:p-8 sticky top-10 border border-indigo-500/10">
                    <h2 class="text-white text-2xl font-black mb-6 tracking-wide flex items-center justify-between">
                        <span>Order Summary</span>
                        <span class="text-xs bg-indigo-500/10 text-indigo-400 px-3 py-1 rounded-full border border-indigo-500/20">
                            {{ count($order->items ?? []) }} {{ count($order->items ?? []) > 1 ? 'Items' : 'Item' }}
                        </span>
                    </h2>

                    <div class="space-y-4 max-h-72 overflow-y-auto pr-2 custom-scroll border-b border-white/5 pb-5">
                        @foreach($order->items ?? [] as $item)
                            <div class="flex items-center justify-between gap-4 p-2 rounded-xl hover:bg-white/[0.01] transition duration-200">
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold text-sm sm:text-base truncate max-w-[200px]">{{ $item['name'] }}</h4>
                                    <p class="text-gray-400 text-xs mt-0.5">Quantity: <span class="text-indigo-400 font-medium">{{ $item['qty'] }}</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-white font-bold text-sm">Rs {{ number_format($item['price'] * $item['qty']) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 space-y-3.5">
                        <div class="flex justify-between text-sm text-gray-400">
                            <span>Shipping</span>
                            <span class="text-emerald-400 font-semibold uppercase tracking-wider text-xs bg-emerald-500/10 px-2 py-0.5 rounded-md border border-emerald-500/10">Free</span>
                        </div>
                        <div class="flex justify-between text-white text-2xl font-black pt-4 border-t border-white/10 mt-2">
                            <span>Total Due</span>
                            <span class="text-indigo-400">Rs {{ number_format($order->total) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    (async function () {
        const publishableKey = @json($publishableKey);
        const clientSecret   = @json($clientSecret);
        const returnUrl      = @json(route('checkout.stripe.return'));
        const payLabel       = @json('Pay Rs ' . number_format($order->total));

        const messageEl    = document.getElementById('payment-message');
        const paymentElDiv = document.getElementById('payment-element');
        const submitBtn    = document.getElementById('submit-button');
        const btnContent   = document.getElementById('button-content');

        function showError(msg) {
            messageEl.textContent = msg;
            messageEl.classList.remove('hidden');
            paymentElDiv.innerHTML = '<div class="py-6 text-center text-sm text-rose-400">Payment form could not load.</div>';
            submitBtn.disabled = true;
        }

        if (!publishableKey) {
            showError('Stripe is not configured. Please set STRIPE_KEY in .env.');
            return;
        }

        if (typeof Stripe === 'undefined') {
            showError('Could not load Stripe.js from js.stripe.com — check your internet connection or firewall.');
            return;
        }

        if (!clientSecret) {
            showError('No client secret received from server — check STRIPE_SECRET in .env and the Laravel log.');
            return;
        }

        let stripe, elements, paymentElement;

        try {
            stripe = Stripe(publishableKey);
            elements = stripe.elements({
                clientSecret,
                appearance: {
                    theme: 'night',
                    variables: {
                        colorPrimary: '#6366f1',
                        colorBackground: '#08090b',
                        colorText: '#ffffff',
                        colorTextSecondary: '#9ca3af',
                        colorDanger: '#ef4444',
                        borderRadius: '12px',
                        fontFamily: 'inherit',
                    },
                    rules: {
                        '.Input': {
                            border: '1px solid rgba(255, 255, 255, 0.06)',
                        },
                        '.Input:focus': {
                            border: '1px solid #6366f1',
                            boxShadow: '0 0 0 4px rgba(99, 102, 241, 0.15)',
                        },
                    },
                },
            });

            paymentElement = elements.create('payment', { layout: 'tabs' });
            paymentElement.mount('#payment-element');

            paymentElement.on('loaderror', (event) => {
                showError('Stripe element failed to load: ' + (event.error?.message || 'unknown error'));
            });
        } catch (err) {
            showError('Stripe init error: ' + err.message);
            console.error(err);
            return;
        }

        document.getElementById('payment-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            submitBtn.disabled = true;
            btnContent.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-sm"></i> Processing…';
            messageEl.classList.add('hidden');

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: { return_url: returnUrl },
            });

            // Only reached when the payment fails immediately — on success
            // Stripe redirects the browser to returnUrl on its own.
            if (error) {
                messageEl.textContent = error.message || 'Payment failed. Please try again.';
                messageEl.classList.remove('hidden');
                submitBtn.disabled = false;
                btnContent.innerHTML = '<i class="fa-solid fa-lock text-xs"></i> ' + payLabel;
            }
        });
    })();
</script>

@endsection
