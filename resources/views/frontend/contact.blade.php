@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<style>
.contact-bg {
    min-height: 100vh;
    background: radial-gradient(circle at top right, #7c3aed 0%, transparent 35%),
                radial-gradient(circle at bottom left, #ec4899 0%, transparent 35%),
                #090b10;
    position: relative;
    overflow: hidden;
    padding: 100px 0 60px 0;
    display: flex;
    align-items: center;
}

#particle-canvas-contact {
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

.contact-wrapper {
    position: relative;
    z-index: 1;
    width: 100%;
}

.contact-card {
    background: linear-gradient(180deg, rgba(26, 22, 42, 0.92), rgba(15, 16, 24, 0.96));
    backdrop-filter: blur(24px);
    border-radius: 1.5rem;
    border: 1px solid rgba(255,255,255,0.06);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    height: 100%;
}

.contact-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.03), transparent);
    transform: translateX(-100%);
    transition: 1s;
    pointer-events: none;
}

.contact-card:hover::before {
    transform: translateX(100%);
}

.contact-card:hover {
    transform: translateY(-6px);
    border-color: rgba(139,92,246,0.3);
    box-shadow: 0 20px 60px -20px rgba(124,58,237,0.4);
}

.card-glow {
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.1;
    pointer-events: none;
}
.card-glow-a { background: #7c3aed; top: -80px; right: -80px; }
.card-glow-b { background: #ec4899; bottom: -80px; left: -80px; }

.info-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(124,58,237,0.3);
}

.input-dark {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    color: white;
    border-radius: 12px;
    padding: 13px 16px;
    width: 100%;
    font-size: 14px;
    transition: all 0.3s ease;
}

.input-dark:focus {
    outline: none;
    border-color: #7c3aed;
    background: rgba(124,58,237,0.06);
    box-shadow: 0 0 0 3px rgba(124,58,237,0.15);
    transform: translateY(-1px);
}

.input-dark::placeholder {
    color: #6b7280;
}

textarea.input-dark {
    resize: none;
    min-height: 120px;
}

.btn-send {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    border: none;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #7c3aed, #6366f1);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    position: relative;
    overflow: hidden;
}

.btn-send::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transform: translateX(-100%);
    transition: 0.6s;
}

.btn-send:hover::after {
    transform: translateX(100%);
}

.btn-send:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 30px -8px rgba(124,58,237,0.6);
}

.btn-send:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.social-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #a78bfa;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 18px;
}

.social-icon:hover {
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    color: white;
    transform: translateY(-5px) scale(1.05);
    border-color: transparent;
    box-shadow: 0 8px 24px rgba(124,58,237,0.3);
}

.info-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 16px;
    border-radius: 12px;
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.04);
    transition: all 0.3s ease;
}

.info-item:hover {
    background: rgba(255,255,255,0.05);
    border-color: rgba(139,92,246,0.15);
    transform: translateX(4px);
}

.info-item .icon-box {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(124,58,237,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #a78bfa;
    flex-shrink: 0;
    font-size: 16px;
}

.info-item .text {
    color: #d1d5db;
    font-size: 14px;
    line-height: 1.5;
}

.info-item .label {
    color: #6b7280;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.badge-glow {
    display: inline-block;
    padding: 4px 16px;
    border-radius: 50px;
    background: rgba(124,58,237,0.12);
    border: 1px solid rgba(124,58,237,0.2);
    color: #a78bfa;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.header-anim {
    animation: fadeDown 0.7s ease;
}
@keyframes fadeDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Toast */
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
    max-width: 400px;
    backdrop-filter: blur(10px);
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

.spinner {
    display: inline-block;
    width: 18px;
    height: 18px;
    border: 2.5px solid rgba(255,255,255,0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Responsive */
@media (max-width: 1024px) {
    .contact-bg {
        padding: 120px 0 40px 0;
    }
}

@media (max-width: 768px) {
    .contact-bg {
        padding: 100px 0 30px 0;
    }
    .contact-card {
        padding: 20px !important;
    }
    .info-item {
        padding: 10px 12px;
    }
    .info-item .text {
        font-size: 13px;
    }
}

@media (max-width: 480px) {
    .contact-bg {
        padding: 90px 0 20px 0;
    }
    .contact-card {
        padding: 16px !important;
    }
    .info-item {
        padding: 8px 10px;
        gap: 10px;
    }
    .info-item .icon-box {
        width: 32px;
        height: 32px;
        font-size: 13px;
    }
    .info-item .text {
        font-size: 12px;
    }
    .input-dark {
        padding: 10px 14px;
        font-size: 13px;
    }
}
</style>

<div class="contact-bg">

    <canvas id="particle-canvas-contact"></canvas>

    <div class="floating one"></div>
    <div class="floating two"></div>
    <div class="floating three"></div>

    <div class="contact-wrapper">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="text-center mb-12 header-anim">
                <span class="badge-glow">📬 Get in Touch</span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mt-3">
                    We'd Love to <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Hear From You</span>
                </h2>
                <p class="text-gray-400 text-sm mt-3 max-w-xl mx-auto">
                    Have a question, feedback, or need help with an order? Reach out to us anytime.
                </p>
            </div>

            <div class="grid lg:grid-cols-12 gap-6 lg:gap-8">

                {{-- LEFT: CONTACT INFO --}}
                <div class="lg:col-span-4">
                    <div class="contact-card p-5 sm:p-6 h-full">

                        <div class="card-glow card-glow-a"></div>
                        <div class="card-glow card-glow-b"></div>

                        <div class="flex items-center gap-3 mb-5">
                            <div class="info-icon">
                                <i class="fa-regular fa-compass"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg">Contact Info</h4>
                                <p class="text-gray-400 text-xs">We're here to help</p>
                            </div>
                        </div>

                        <div class="space-y-2.5">
                            <div class="info-item">
                                <div class="icon-box"><i class="fa-solid fa-envelope"></i></div>
                                <div>
                                    <p class="label">Email</p>
                                    <p class="text">support@novacart.com</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="icon-box"><i class="fa-solid fa-phone"></i></div>
                                <div>
                                    <p class="label">Phone</p>
                                    <p class="text">+92 300 1234567</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="icon-box"><i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <p class="label">Address</p>
                                    <p class="text">Lahore, Pakistan</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="icon-box"><i class="fa-regular fa-clock"></i></div>
                                <div>
                                    <p class="label">Working Hours</p>
                                    <p class="text">Mon - Sat, 9AM - 6PM</p>
                                </div>
                            </div>
                        </div>

                       
                        

                    </div>
                </div>

                {{-- RIGHT: CONTACT FORM --}}
                <div class="lg:col-span-8">
                    <div class="contact-card p-5 sm:p-7 md:p-8 h-full">

                        <div class="card-glow card-glow-a" style="top:-100px; right:-100px;"></div>
                        <div class="card-glow card-glow-b" style="bottom:-100px; left:-100px;"></div>

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                                <i class="fa-regular fa-pen-to-square text-purple-400"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-xl">Send us a message</h3>
                                <p class="text-gray-400 text-xs">We'll respond within 24 hours</p>
                            </div>
                        </div>

                        <form id="contact-form">
                            @csrf

                            <div class="grid sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="text-gray-400 text-xs font-semibold uppercase tracking-wider block mb-1.5">Full Name</label>
                                    <input type="text" name="name" placeholder="John Doe" class="input-dark" required>
                                </div>
                                <div>
                                    <label class="text-gray-400 text-xs font-semibold uppercase tracking-wider block mb-1.5">Email Address</label>
                                    <input type="email" name="email" placeholder="john@example.com" class="input-dark" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-gray-400 text-xs font-semibold uppercase tracking-wider block mb-1.5">Subject</label>
                                <input type="text" name="subject" placeholder="What's this about?" class="input-dark" required>
                            </div>

                            <div class="mb-6">
                                <label class="text-gray-400 text-xs font-semibold uppercase tracking-wider block mb-1.5">Message</label>
                                <textarea name="message" rows="5" placeholder="Write your message here..." class="input-dark" required></textarea>
                            </div>

                            <button type="submit" class="btn-send" id="contact-submit-btn">
                                <i class="fa-regular fa-paper-plane"></i>
                                Send Message
                            </button>

                            <p class="text-gray-500 text-xs text-center mt-3">
                                <i class="fa-solid fa-lock text-[10px] mr-1"></i>
                                Your information is secure with us
                            </p>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

<script>
// ===================== PARTICLE BACKGROUND =====================
(function () {
    const canvas = document.getElementById('particle-canvas-contact');
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
        const count = Math.min(50, Math.floor((canvas.width * canvas.height) / 20000));
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

// ===================== TOAST =====================
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

// ===================== SUBMIT FORM (AJAX) =====================
document.getElementById('contact-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const button = document.getElementById('contact-submit-btn');
    const originalText = button.innerHTML;

    button.disabled = true;
    button.innerHTML = '<span class="spinner"></span> Sending...';

    fetch('{{ route("contact.submit") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        button.disabled = false;
        button.innerHTML = originalText;

        if (data.success) {
            showToast('✅ ' + (data.message || 'Message sent successfully!'), 'success');
            form.reset();
        } else {
            showToast('❌ ' + (data.message || 'Something went wrong'), 'error');
        }
    })
    .catch(() => {
        button.disabled = false;
        button.innerHTML = originalText;
        showToast('❌ Something went wrong', 'error');
    });
});
</script>

@endsection