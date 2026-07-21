@extends('layouts.app')

@section('title', 'Gift Finder')

@section('content')

<style>
.giftfinder-bg {
    min-height: 100vh;
    background: radial-gradient(circle at top right, #7c3aed 0%, transparent 35%),
                radial-gradient(circle at bottom left, #ec4899 0%, transparent 35%),
                #090b10;
    position: relative;
    overflow: hidden;
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

.header-anim { animation: fadeTop 0.7s ease; }
@keyframes fadeTop {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== STEP PROGRESS ===== */
.step-track {
    height: 4px;
    background: rgba(255,255,255,0.08);
    border-radius: 999px;
    overflow: hidden;
}
.step-fill {
    height: 100%;
    background: linear-gradient(90deg, #7c3aed, #ec4899);
    border-radius: 999px;
    transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.step-dot {
    width: 30px; height: 30px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    border: 2px solid rgba(255,255,255,0.15);
    background: #1a1c24;
    color: #6b7280;
    transition: all 0.4s ease;
    position: relative;
    z-index: 2;
}
.step-dot.done {
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    border-color: transparent;
    color: white;
    box-shadow: 0 0 0 5px rgba(124,58,237,0.2);
}

/* ===== PREMIUM CARD WRAPPER ===== */
.gift-card-wrap {
    position: relative;
    border-radius: 2rem;
    padding: 2px;
    transform-style: preserve-3d;
}
.gift-card-wrap::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 2rem;
    padding: 2px;
    background: conic-gradient(from var(--angle, 0deg), #7c3aed, #ec4899, #6366f1, #7c3aed);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    animation: spin-border 6s linear infinite;
    opacity: 0.9;
}
@property --angle {
    syntax: '<angle>';
    initial-value: 0deg;
    inherits: false;
}
@keyframes spin-border { to { --angle: 360deg; } }

.gift-card {
    background: linear-gradient(180deg, rgba(26, 22, 42, 0.92), rgba(15, 16, 24, 0.96));
    backdrop-filter: blur(24px);
    border-radius: calc(2rem - 2px);
    position: relative;
    overflow: hidden;
    box-shadow:
        0 30px 60px -20px rgba(124, 58, 237, 0.35),
        0 10px 30px -10px rgba(0,0,0,0.6),
        inset 0 1px 0 rgba(255,255,255,0.06);
    transition: transform 0.15s ease-out, box-shadow 0.4s ease;
}
.gift-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    transform: translateX(-100%);
    transition: 1s;
    pointer-events: none;
    z-index: 1;
}
.gift-card-wrap:hover .gift-card::before { transform: translateX(100%); }
.gift-card:hover {
    box-shadow:
        0 40px 80px -20px rgba(124, 58, 237, 0.5),
        0 15px 40px -10px rgba(0,0,0,0.7),
        inset 0 1px 0 rgba(255,255,255,0.08);
}

.card-glow-a, .card-glow-b {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    pointer-events: none;
    z-index: 0;
}
.card-glow-a {
    width: 220px; height: 220px; background: #7c3aed; opacity: 0.15;
    top: -60px; left: -60px;
    animation: drift-a 10s ease-in-out infinite alternate;
}
.card-glow-b {
    width: 200px; height: 200px; background: #ec4899; opacity: 0.13;
    bottom: -50px; right: -50px;
    animation: drift-b 12s ease-in-out infinite alternate;
}
@keyframes drift-a { to { transform: translate(30px, 20px); } }
@keyframes drift-b { to { transform: translate(-25px, -15px); } }

.gift-card-inner { position: relative; z-index: 2; }

.pulse-dot { animation: pulse-dot 1.6s ease-in-out infinite; }
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: .4; transform: scale(1.4); }
}

/* ===== PILLS ===== */
.pill {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255,255,255,0.08);
    position: relative;
    overflow: hidden;
}
.pill:hover {
    transform: translateY(-3px);
    border-color: rgba(139,92,246,0.5);
    box-shadow: 0 10px 20px -8px rgba(139,92,246,0.4);
}
.pill.active {
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    border-color: transparent;
    color: white;
    box-shadow: 0 10px 25px -6px rgba(124,58,237,0.7);
    transform: translateY(-2px) scale(1.03);
}
.pill.active i { color: white !important; }

.pill-check {
    width: 16px; height: 16px;
    border-radius: 50%;
    background: white;
    display: flex; align-items: center; justify-content: center;
}

/* Ripple */
.ripple-el {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    transform: scale(0);
    animation: ripple-anim 0.6s ease-out forwards;
    pointer-events: none;
}
@keyframes ripple-anim {
    to { transform: scale(3); opacity: 0; }
}

@keyframes bounce-in {
    0% { transform: scale(0.9); opacity: 0; }
    60% { transform: scale(1.03); opacity: 1; }
    100% { transform: scale(1); }
}
.bounce-in { animation: bounce-in 0.4s ease; }

@keyframes gift-float {
    0%, 100% { transform: translateY(0) rotate(-3deg); }
    50% { transform: translateY(-8px) rotate(3deg); }
}
.gift-float {
    display: inline-block;
    animation: gift-float 3s ease-in-out infinite;
    filter: drop-shadow(0 8px 16px rgba(0,0,0,0.4));
}

.find-btn { position: relative; overflow: hidden; }
.find-btn::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}
.find-btn:hover::after { transform: translateX(100%); }
.find-btn:not(:disabled):hover {
    box-shadow: 0 15px 35px -8px rgba(124,58,237,0.7) !important;
}
.find-btn:disabled { opacity: 0.35; cursor: not-allowed; }

/* Confetti */
.confetti-piece {
    position: absolute;
    top: -10px;
    border-radius: 2px;
    animation: confetti-fall linear forwards;
}
@keyframes confetti-fall {
    to { transform: translateY(240px) rotate(540deg); opacity: 0; }
}

/* Spinner */
.spinner {
    width: 18px; height: 18px;
    border: 2.5px solid rgba(255,255,255,0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.typewriter-cursor {
    display: inline-block;
    width: 2px;
    background: #a78bfa;
    animation: blink 0.9s step-end infinite;
}
@keyframes blink { 50% { opacity: 0; } }

[x-cloak] { display: none !important; }
</style>

<div class="giftfinder-bg py-16">

    <canvas id="particle-canvas"></canvas>

    <!-- Floating Background Orbs -->
    <div class="floating one"></div>
    <div class="floating two"></div>
    <div class="floating three"></div>

    <div class="max-w-3xl mx-auto px-6 lg:px-8 relative z-10">

        {{-- SECTION HEADER --}}
        <div class="text-center mb-10 header-anim">
            <p class="text-purple-400 text-xs font-bold tracking-[0.2em] uppercase mb-3 flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-purple-400 pulse-dot"></span>
                Perfect Gift, Every Time
            </p>
            <h2 class="text-5xl font-black text-white tracking-tight mb-4">
                <span class="gift-float inline-block">🎁</span>
                Gift <span class="bg-gradient-to-r from-purple-400 via-pink-400 to-indigo-400 bg-clip-text text-transparent">Finder</span>
            </h2>
            <p id="gf-subtitle" class="text-gray-400 text-sm max-w-md mx-auto min-h-[20px]"></p>
        </div>

        {{-- PREMIUM 3D CARD --}}
        <div
            x-data="{
                giftFor: '',
                occasion: '',
                loading: false,
                confetti: [],
                rotateX: 0,
                rotateY: 0,
                get canSubmit(){ return this.giftFor !== '' && this.occasion !== ''; },
                get stepsDone(){
                    let n = 0;
                    if (this.giftFor) n++;
                    if (this.occasion) n++;
                    return n;
                },
                handleMove(e){
                    const rect = $el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const cx = rect.width / 2;
                    const cy = rect.height / 2;
                    this.rotateY = ((x - cx) / cx) * 4;
                    this.rotateX = -((y - cy) / cy) * 4;
                },
                resetTilt(){ this.rotateX = 0; this.rotateY = 0; },
                ripple(e){
                    const btn = e.currentTarget;
                    const rect = btn.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const el = document.createElement('span');
                    el.className = 'ripple-el';
                    el.style.width = el.style.height = size + 'px';
                    el.style.left = (e.clientX - rect.left - size / 2) + 'px';
                    el.style.top = (e.clientY - rect.top - size / 2) + 'px';
                    btn.appendChild(el);
                    setTimeout(() => el.remove(), 600);
                },
                burstConfetti(){
                    const colors = ['#7c3aed', '#ec4899', '#6366f1', '#f59e0b'];
                    const pieces = [];
                    for (let i = 0; i < 18; i++) {
                        pieces.push({
                            id: Date.now() + i,
                            left: Math.random() * 100,
                            color: colors[Math.floor(Math.random() * colors.length)],
                            duration: (0.8 + Math.random() * 0.6).toFixed(2),
                            width: 5 + Math.random() * 4,
                            height: 8 + Math.random() * 6
                        });
                    }
                    this.confetti = pieces;
                    setTimeout(() => this.confetti = [], 1500);
                },
                selectGift(person){
                    this.giftFor = person;
                    if (this.occasion) this.burstConfetti();
                },
                selectOccasion(event){
                    this.occasion = event;
                    if (this.giftFor) this.burstConfetti();
                },
                handleSubmit(e){
                    this.loading = true;
                }
            }"
            @mousemove="handleMove($event)"
            @mouseleave="resetTilt()"
            :style="`transform: perspective(1200px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`"
            class="gift-card-wrap transition-transform duration-150 ease-out relative">

            {{-- CONFETTI LAYER --}}
            <div class="absolute inset-x-0 top-0 h-0 overflow-visible pointer-events-none z-30">
                <template x-for="piece in confetti" :key="piece.id">
                    <span class="confetti-piece"
                          :style="`left: ${piece.left}%; background: ${piece.color}; width: ${piece.width}px; height: ${piece.height}px; animation-duration: ${piece.duration}s;`">
                    </span>
                </template>
            </div>

            <div class="gift-card p-8 lg:p-10">

                <div class="card-glow-a"></div>
                <div class="card-glow-b"></div>

                <div class="gift-card-inner">

                    {{-- STEP PROGRESS --}}
                    <div class="flex items-center gap-3 mb-9">
                        <div class="step-dot" :class="giftFor ? 'done' : ''">
                            <template x-if="giftFor"><i class="fa-solid fa-check"></i></template>
                            <template x-if="!giftFor"><span>1</span></template>
                        </div>
                        <div class="step-track flex-1">
                            <div class="step-fill" :style="`width: ${(stepsDone / 2) * 100}%`"></div>
                        </div>
                        <div class="step-dot" :class="occasion ? 'done' : ''">
                            <template x-if="occasion"><i class="fa-solid fa-check"></i></template>
                            <template x-if="!occasion"><span>2</span></template>
                        </div>
                    </div>

                    <form action="{{ route('gift.search') }}" method="POST" class="space-y-8" @submit="handleSubmit">

                        @csrf

                        {{-- GIFT FOR --}}
                        <div>
                            <label class="text-white font-bold text-sm mb-4 flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-purple-500/20 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-purple-400 text-xs"></i>
                                </span>
                                Gift For
                            </label>

                            <input type="hidden" name="gift_for" x-model="giftFor">

                            <div class="flex flex-wrap gap-3">
                                @php
                                    $personIcons = [
                                        'Mother' => 'fa-heart',
                                        'Father' => 'fa-shield-heart',
                                        'Brother' => 'fa-people-arrows',
                                        'Sister' => 'fa-star',
                                        'Friend' => 'fa-handshake',
                                        'Husband' => 'fa-ring',
                                        'Wife' => 'fa-gem',
                                    ];
                                @endphp
                                @foreach($personIcons as $person => $icon)
                                    <button
                                        type="button"
                                        @click="ripple($event); selectGift('{{ $person }}')"
                                        :class="giftFor === '{{ $person }}' ? 'active' : 'bg-white/5 text-gray-300'"
                                        class="pill px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2">
                                        <i class="fa-solid {{ $icon }} text-xs" :class="giftFor === '{{ $person }}' ? 'text-white' : 'text-purple-400'"></i>
                                        {{ $person }}
                                        <template x-if="giftFor === '{{ $person }}'">
                                            <span class="pill-check"><i class="fa-solid fa-check text-[8px] text-purple-600"></i></span>
                                        </template>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- OCCASION --}}
                        <div>
                            <label class="text-white font-bold text-sm mb-4 flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-pink-500/20 flex items-center justify-center">
                                    <i class="fa-solid fa-champagne-glasses text-pink-400 text-xs"></i>
                                </span>
                                Occasion
                            </label>

                            <input type="hidden" name="occasion" x-model="occasion">

                            <div class="flex flex-wrap gap-3">
                                @php
                                    $eventIcons = [
                                        'Birthday' => 'fa-cake-candles',
                                        'Anniversary' => 'fa-heart-circle-check',
                                        'Eid' => 'fa-moon',
                                        'Graduation' => 'fa-graduation-cap',
                                        'Wedding' => 'fa-solid fa-champagne-glasses',
                                    ];
                                @endphp
                                @foreach($eventIcons as $event => $icon)
                                    <button
                                        type="button"
                                        @click="ripple($event); selectOccasion('{{ $event }}')"
                                        :class="occasion === '{{ $event }}' ? 'active' : 'bg-white/5 text-gray-300'"
                                        class="pill px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2">
                                        <i class="fa-solid {{ $icon }} text-xs" :class="occasion === '{{ $event }}' ? 'text-white' : 'text-pink-400'"></i>
                                        {{ $event }}
                                        <template x-if="occasion === '{{ $event }}'">
                                            <span class="pill-check"><i class="fa-solid fa-check text-[8px] text-pink-600"></i></span>
                                        </template>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- SELECTED SUMMARY --}}
                        <div
                            x-show="giftFor && occasion"
                            x-cloak
                            x-transition
                            class="bounce-in px-5 py-4 rounded-xl bg-white/5 border border-white/10 text-sm text-gray-300 flex items-center gap-2">
                            <i class="fa-solid fa-wand-magic-sparkles text-purple-400"></i>
                            Finding gifts for
                            <span class="text-white font-bold" x-text="giftFor"></span>
                            for their
                            <span class="text-white font-bold" x-text="occasion"></span>
                            celebration...
                        </div>

                        {{-- SUBMIT --}}
                        <button
                            type="submit"
                            :disabled="!canSubmit || loading"
                            class="find-btn w-full py-4 rounded-xl text-white text-base font-bold shadow-lg transition-all duration-300 flex items-center justify-center gap-2"
                            :class="canSubmit ? 'bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 hover:scale-[1.02] shadow-purple-900/40' : 'bg-white/5'">
                            <template x-if="!loading">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    Find Gifts
                                </span>
                            </template>
                            <template x-if="loading">
                                <span class="flex items-center gap-2">
                                    <span class="spinner"></span>
                                    Searching...
                                </span>
                            </template>
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
// Typewriter subtitle
(function () {
    const el = document.getElementById('gf-subtitle');
    if (!el) return;
    const text = "Tell us who you're shopping for and the occasion, and we'll find the perfect gift for you.";
    let i = 0;
    el.innerHTML = '<span id="gf-txt"></span><span class="typewriter-cursor">&nbsp;</span>';
    const txtEl = document.getElementById('gf-txt');
    function type() {
        if (i <= text.length) {
            txtEl.textContent = text.slice(0, i);
            i++;
            setTimeout(type, 22);
        }
    }
    type();
})();

// Particle background
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
</script>

@endsection