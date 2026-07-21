@extends('layouts.app')
@section('content')
<style>
.profile-bg {
    min-height: 100vh;
    background: radial-gradient(circle at top left, #3730a3 0%, transparent 35%),
                radial-gradient(circle at bottom right, #0ea5e9 0%, transparent 35%),
                #090b10;
    position: relative;
    overflow: hidden;
}
.profile-card {
    background: rgba(22, 28, 42, 0.78);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 1.6rem;
    transition: all 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
.profile-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.04), transparent);
    transform: translateX(-100%);
    transition: 0.7s;
}
.profile-card:hover::before {
    transform: translateX(100%);
}
.profile-card:hover {
    transform: translateY(-8px) scale(1.01);
    box-shadow: 0 25px 60px rgba(99, 102, 241, 0.25),
                0 0 40px rgba(59, 130, 246, 0.08);
}
.input-dark {
    background: #1a2233;
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: white;
    transition: all 0.35s ease;
}
.input-dark:hover {
    border-color: #4f46e5;
    transform: translateY(-2px);
}
.input-dark:focus {
    outline: none;
    background: #202a40;
    transform: translateY(-3px) scale(1.01);
    border-color: #6366f1;
    box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.15);
}
.avatar-ring {
    padding: 6px;
    border-radius: 36px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    display: inline-block;
}
.avatar-box {
    width: 120px;
    height: 120px;
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #6366f1, #8b5cf6, #06b6d4);
    background-size: 300% 300%;
    animation: gradientMove 6s infinite alternate;
    box-shadow: 0 15px 45px rgba(99, 102, 241, 0.45);
    transition: all 0.4s ease;
}
.avatar-box:hover {
    transform: rotate(-8deg) scale(1.08);
}
@keyframes gradientMove {
    0% { background-position: left; }
    100% { background-position: right; }
}
.online-dot {
    position: absolute;
    bottom: 6px;
    right: 6px;
    width: 18px;
    height: 18px;
    background: #10b981;
    border: 4px solid #161c2a;
    border-radius: 50%;
}
.member-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.15), rgba(249, 115, 22, 0.15));
    border: 1px solid rgba(234, 179, 8, 0.3);
    color: #f59e0b;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.profile-divider {
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}
.profile-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.04);
    transition: all 0.3s ease;
    text-decoration: none !important;
}
.profile-link:hover {
    background: linear-gradient(90deg, rgba(79, 70, 229, 0.2), rgba(99, 102, 241, 0.2));
    border-color: rgba(99, 102, 241, 0.4);
    transform: translateX(5px);
}
.save-btn {
    width: 100%;
    padding: 16px;
    border-radius: 16px;
    font-size: 16px;
    font-weight: 700;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    border: none;
}
.save-btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.18);
    transform: skewX(-20deg);
    transition: 0.6s;
}
.save-btn:hover::before {
    left: 120%;
}
.save-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 40px rgba(99, 102, 241, 0.45);
}
h1 {
    animation: fadeTop 0.7s ease;
}
@keyframes fadeTop {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.floating {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.18;
    animation: float 8s infinite alternate;
    pointer-events: none;
}
.one {
    width: 250px;
    height: 250px;
    background: #4f46e5;
    top: -80px;
    left: -80px;
}
.two {
    width: 220px;
    height: 220px;
    background: #06b6d4;
    right: -50px;
    top: 120px;
}
.three {
    width: 180px;
    height: 180px;
    background: #8b5cf6;
    bottom: 40px;
    left: 40%;
}
@keyframes float {
    100% {
        transform: translateY(40px) translateX(30px);
    }
}
.form-card {
    position: relative;
    background: rgba(20, 25, 38, 0.82);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 28px;
    overflow: hidden;
    transition: .45s;
}
.form-card::before {
    content: "";
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6, #06b6d4, #6366f1);
    background-size: 300% 300%;
    animation: borderMove 7s linear infinite;
    z-index: -1;
    filter: blur(18px);
    opacity: .55;
}
.form-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(99, 102, 241, .30),
                0 0 50px rgba(14, 165, 233, .18);
}
@keyframes borderMove {
    0% { background-position: left; }
    100% { background-position: right; }
}
.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 25px;
}
.form-divider {
    margin: 35px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    position: relative;
}
.form-divider span {
    position: absolute;
    left: 20px;
    top: -12px;
    background: #171d2c;
    padding: 0 14px;
    color: #818cf8;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .5px;
}
.input-group {
    margin-bottom: 22px;
}
.input-group label {
    display: block;
    color: #cbd5e1;
    margin-bottom: 10px;
    font-size: 14px;
    font-weight: 600;
}
</style>

<div class="profile-bg py-20">
    <!-- Floating Background Orbs -->
    <div class="floating one"></div>
    <div class="floating two"></div>
    <div class="floating three"></div>
    
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        {{-- HEADER --}}
        <div class="mb-12">
            <h1 class="text-4xl font-black text-white tracking-tight">
                My <span class="text-indigo-400">Profile</span>
            </h1>
            <p class="text-gray-400 mt-2 text-sm">
                Manage your account information and preferences
            </p>
        </div>

        {{-- STATUS MESSAGES --}}
        @if(session('success'))
            <div class="mb-8 px-5 py-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm">
                <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-8 px-5 py-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- GRID SYSTEM (gap-8 adds clean spacing between cards) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- LEFT: PREMIUM PROFILE CARD --}}
            <div class="profile-card p-8 text-center">
                {{-- Avatar --}}
                <div class="relative inline-block mb-6">
                    <div class="avatar-ring">
                        <div class="avatar-box">
                            <i class="fa-solid fa-user text-5xl text-white"></i>
                        </div>
                    </div>
                    <span class="online-dot"></span>
                </div>

                {{-- User Info --}}
                <h2 class="text-2xl font-bold text-white">
                    {{ $user->name }}
                </h2>
                <p class="text-gray-400 text-sm mt-2 break-all">
                    {{ $user->email }}
                </p>

                <div class="mt-5">
                    <span class="member-badge">
                        <i class="fa-solid fa-crown"></i>
                        Member
                    </span>
                </div>

                {{-- Divider --}}
                <div class="profile-divider my-8"></div>

                {{-- Sidebar Navigation (space-y-4 keeps links separated) --}}
                <div class="space-y-4 text-left">
                    {{-- My Orders --}}
                    <a href="{{ route('orders.index') }}" class="profile-link group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center transition-all duration-300 group-hover:bg-white/20">
                                <i class="fa-solid fa-box text-indigo-400 text-lg group-hover:text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">My Orders</h4>
                                <p class="text-gray-400 text-xs">View & track your purchases</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-arrow-right text-gray-400 transition-all duration-300 group-hover:text-white group-hover:translate-x-1"></i>
                    </a>

                    {{-- Wishlist --}}
                    <a href="{{ route('wishlist') }}" class="profile-link group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-pink-500/10 flex items-center justify-center transition-all duration-300 group-hover:bg-white/20">
                                <i class="fa-solid fa-heart text-pink-400 text-lg group-hover:text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Wishlist</h4>
                                <p class="text-gray-400 text-xs">Products you've saved</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-arrow-right text-gray-400 transition-all duration-300 group-hover:text-white group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>

            {{-- RIGHT: EDIT FORM & PASSWORD FORMS --}}
            <div class="lg:col-span-2">
                <div class="form-card p-10">
                    <h2 class="section-title">
                        <i class="fa-solid fa-user-gear text-indigo-400"></i>
                        Profile Settings
                    </h2>

                    <form action="{{ route('profile.update') }}" method="POST"
                          autocomplete="off"
                          x-data="{ currentPw: '', newPw: '', confirmPw: '', emailVal: '{{ old('email', $user->email) }}' }">
                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="input-group">
                                <label>Full Name</label>
                                <input type="text" name="name" value="{{ old('name',$user->name) }}"
                                       class="input-dark w-full px-4 py-3 rounded-xl"
                                       autocomplete="off" required>
                            </div>

                            <div class="input-group">
                                <label>Email Address</label>
                                {{--
                                    NOTE: is field ka type="email" aur name attribute jaan boojh kar
                                    hataye hain, taake Chrome isay login-form ka email field na samjhe
                                    aur saved accounts ka dropdown na dikhaye. Real value hidden
                                    input se submit hoti hai.
                                --}}
                                <input
                                    type="text"
                                    inputmode="email"
                                    x-model="emailVal"
                                    class="input-dark w-full px-4 py-3 rounded-xl"
                                    autocomplete="off"
                                    data-lpignore="true"
                                    data-1p-ignore
                                    data-form-type="other"
                                    required>
                                <input type="hidden" name="email" :value="emailVal">
                            </div>
                        </div>

                        <div class="form-divider">
                            <span>SECURITY</span>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="input-group">
                                <label>
                                    Current Password
                                    <span x-show="newPw.length > 0" x-cloak class="text-rose-400">*</span>
                                </label>
                                <input
                                    type="text"
                                    style="-webkit-text-security: disc; text-security: disc;"
                                    x-model="currentPw"
                                    class="input-dark w-full px-4 py-3 rounded-xl"
                                    placeholder="Current Password"
                                    autocomplete="off"
                                    autocapitalize="off"
                                    autocorrect="off"
                                    spellcheck="false"
                                    data-lpignore="true"
                                    data-1p-ignore
                                    data-form-type="other">
                                <input type="hidden" name="current_password" :value="currentPw">
                            </div>

                            <div class="input-group">
                                <label>New Password</label>
                                <input
                                    type="text"
                                    style="-webkit-text-security: disc; text-security: disc;"
                                    x-model="newPw"
                                    class="input-dark w-full px-4 py-3 rounded-xl"
                                    placeholder="New Password"
                                    autocomplete="off"
                                    autocapitalize="off"
                                    autocorrect="off"
                                    spellcheck="false"
                                    data-lpignore="true"
                                    data-1p-ignore
                                    data-form-type="other">
                                <input type="hidden" name="new_password" :value="newPw">
                            </div>
                        </div>

                        <p x-show="newPw.length > 0" x-cloak x-transition class="text-xs text-gray-400 -mt-4 mb-6">
                            <i class="fa-solid fa-circle-info mr-1"></i>
                            Enter your current password to set a new password.
                        </p>

                        <div class="input-group">
                            <label>Confirm Password</label>
                            <input
                                type="text"
                                style="-webkit-text-security: disc; text-security: disc;"
                                x-model="confirmPw"
                                class="input-dark w-full px-4 py-3 rounded-xl"
                                placeholder="Confirm Password"
                                autocomplete="off"
                                autocapitalize="off"
                                autocorrect="off"
                                spellcheck="false"
                                data-lpignore="true"
                                data-1p-ignore
                                data-form-type="other">
                            <input type="hidden" name="new_password_confirmation" :value="confirmPw">
                        </div>

                        <div class="mt-8">
                            <button
                                type="submit"
                                class="save-btn"
                                @click="
                                    if (newPw.length > 0 && currentPw.length === 0) {
                                        $event.preventDefault();
                                        alert('Enter your current password to set a new password.');
                                    }
                                ">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div> {{-- GRID END --}}
    </div>
</div>
@endsection