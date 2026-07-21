@extends('layouts.app')

@section('title', 'Mood Shop')

@section('content')

<style>
.moodshop-bg {
    min-height: 100vh;
    background: radial-gradient(circle at top left, #3730a3 0%, transparent 35%),
                radial-gradient(circle at bottom right, #db2777 0%, transparent 35%),
                #090b10;
    position: relative;
    overflow: hidden;
}

.floating {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.18;
    animation: float 8s infinite alternate;
    pointer-events: none;
}
.one { width: 300px; height: 300px; background: #6366f1; top: -80px; left: -80px; }
.two { width: 260px; height: 260px; background: #ec4899; right: -60px; top: 200px; }
.three { width: 220px; height: 220px; background: #8b5cf6; bottom: 40px; left: 40%; }
@keyframes float {
    100% { transform: translateY(40px) translateX(30px); }
}

.header-anim {
    animation: fadeTop 0.7s ease;
}
@keyframes fadeTop {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}

.mood-card {
    background: rgba(22, 28, 42, 0.78);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 1.75rem;
    position: relative;
    overflow: hidden;
    transform-style: preserve-3d;
    transition: transform 0.15s ease-out, box-shadow 0.3s ease, border-color 0.3s ease;
}

.mood-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    transform: translateX(-100%);
    transition: 0.7s;
    pointer-events: none;
}
.mood-card:hover::before {
    transform: translateX(100%);
}

.mood-glow {
    position: absolute;
    inset: -2px;
    border-radius: 1.75rem;
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
    filter: blur(20px);
}
.mood-card:hover .mood-glow {
    opacity: 0.45;
}

@keyframes fade-up {
    from { opacity: 0; transform: translateY(28px); }
    to { opacity: 1; transform: translateY(0); }
}
.reveal { opacity: 0; }
.reveal.is-visible { animation: fade-up 0.6s ease forwards; }

@keyframes emoji-float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(-4deg); }
}
.emoji-float {
    display: inline-block;
    animation: emoji-float 3s ease-in-out infinite;
    filter: drop-shadow(0 8px 16px rgba(0,0,0,0.4));
}

.pulse-dot {
    animation: pulse-dot 1.6s ease-in-out infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: .4; transform: scale(1.4); }
}

.mood-btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}
.mood-btn::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}
.mood-btn:hover::after {
    transform: translateX(100%);
}

[x-cloak] { display: none !important; }
</style>

<div class="moodshop-bg py-16">

    <!-- Floating Background Orbs -->
    <div class="floating one"></div>
    <div class="floating two"></div>
    <div class="floating three"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        {{-- SECTION HEADER --}}
        <div class="text-center mb-16 header-anim">
            <p class="text-pink-400 text-xs font-bold tracking-[0.2em] uppercase mb-3 flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-pink-400 pulse-dot"></span>
                Shop By Vibe
            </p>
            <h2 class="text-5xl font-black text-white tracking-tight mb-4">
                Mood <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Shop</span>
            </h2>
            <p class="text-gray-400 text-sm max-w-xl mx-auto">
               Every mood deserves the perfect style. Select your mood, and we'll find the perfect products for you.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse($moods as $index => $mood)

                @php
                    $config = match($mood->name){
                        'Party' => ['emoji' => '🥳', 'from' => '#f43f5e', 'to' => '#db2777'],
                        'Office' => ['emoji' => '💼', 'from' => '#3b82f6', 'to' => '#4f46e5'],
                        'Casual' => ['emoji' => '😎', 'from' => '#f59e0b', 'to' => '#ea580c'],
                        'Self Care' => ['emoji' => '🧖', 'from' => '#10b981', 'to' => '#14b8a6'],
                        'Wedding' => ['emoji' => '💍', 'from' => '#a855f7', 'to' => '#ec4899'],
                        default => ['emoji' => '🛍️', 'from' => '#6366f1', 'to' => '#8b5cf6'],
                    };
                @endphp

                <div
                    x-data="{
                        visible: false,
                        rotateX: 0,
                        rotateY: 0,
                        handleMove(e){
                            const rect = $el.getBoundingClientRect();
                            const x = e.clientX - rect.left;
                            const y = e.clientY - rect.top;
                            const cx = rect.width / 2;
                            const cy = rect.height / 2;
                            this.rotateY = ((x - cx) / cx) * 8;
                            this.rotateX = -((y - cy) / cy) * 8;
                        },
                        resetTilt(){
                            this.rotateX = 0;
                            this.rotateY = 0;
                        }
                    }"
                    x-init="
                        $nextTick(() => {
                            const obs = new IntersectionObserver((entries) => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting) {
                                        visible = true;
                                        obs.disconnect();
                                    }
                                });
                            }, { threshold: 0.1 });
                            obs.observe($el);
                        })
                    "
                    @mousemove="handleMove($event)"
                    @mouseleave="resetTilt()"
                    :class="visible ? 'is-visible' : ''"
                    :style="`transform: perspective(900px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`"
                    class="mood-card reveal p-8 text-center hover:shadow-2xl"
                    style="animation-delay: {{ $index * 90 }}ms; box-shadow: 0 20px 40px -20px rgba(0,0,0,0.5);">

                    {{-- GLOW --}}
                    <div class="mood-glow" style="background: linear-gradient(135deg, {{ $config['from'] }}, {{ $config['to'] }});"></div>

                    <div class="relative z-10">

                        <div class="w-24 h-24 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg"
                             style="background: linear-gradient(135deg, {{ $config['from'] }}, {{ $config['to'] }});">
                            <span class="text-5xl emoji-float">{{ $config['emoji'] }}</span>
                        </div>

                        <h4 class="text-2xl font-black text-white mb-2">
                            {{ $mood->name }}
                        </h4>

                        <p class="text-gray-500 text-sm mb-6">
                            Curated products for your {{ strtolower($mood->name) }} moments.
                        </p>

                        <a href="{{ route('mood.products', $mood->id) }}"
                           class="mood-btn inline-flex items-center justify-center gap-2 w-full py-3 rounded-xl text-white text-sm font-bold shadow-lg transition-all duration-300 hover:scale-[1.03]"
                           style="background: linear-gradient(135deg, {{ $config['from'] }}, {{ $config['to'] }});">
                            Explore Products
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-full text-center py-20">
                    <div class="w-20 h-20 rounded-full bg-indigo-500/10 flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-face-flushed text-3xl text-indigo-400"></i>
                    </div>
                    <h4 class="text-white text-xl font-bold mb-2">No moods found</h4>
                    <p class="text-gray-500 text-sm">Check back soon, new moods are on the way.</p>
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection