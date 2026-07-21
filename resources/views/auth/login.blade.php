<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCart | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
           background: linear-gradient(rgba(12, 15, 35, .7), rgba(12, 15, 35, .7)),
    url('{{ asset("images/logi.webp") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* ============================================
           FULL SCREEN BACKGROUND EFFECTS
           ============================================ */

        /* 1. FULL SCREEN FLOATING GEOMETRIC SHAPES */
        .shapes {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            border: 2px solid rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            animation: float-shape 20s ease-in-out infinite alternate;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 8%;
            left: 3%;
            border-color: rgba(6, 182, 212, 0.15);
            animation-duration: 18s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            bottom: 12%;
            right: 3%;
            border-color: rgba(139, 92, 246, 0.12);
            animation-duration: 22s;
            animation-delay: 2s;
            border-radius: 30% 70% 50% 50% / 50% 40% 60% 50%;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 55%;
            left: 2%;
            border-color: rgba(59, 130, 246, 0.15);
            animation-duration: 15s;
            animation-delay: 4s;
            border-radius: 40% 60% 30% 70% / 60% 30% 70% 40%;
        }

        .shape:nth-child(4) {
            width: 150px;
            height: 150px;
            top: 3%;
            right: 5%;
            border-color: rgba(244, 63, 94, 0.08);
            animation-duration: 25s;
            animation-delay: 1s;
            border-radius: 70% 30% 60% 40% / 30% 60% 40% 70%;
        }

        .shape:nth-child(5) {
            width: 100px;
            height: 100px;
            bottom: 25%;
            right: 8%;
            border-color: rgba(251, 191, 36, 0.08);
            animation-duration: 20s;
            animation-delay: 3s;
            border-radius: 60% 40% 70% 30% / 40% 70% 30% 60%;
        }

        .shape:nth-child(6) {
            width: 70px;
            height: 70px;
            top: 70%;
            left: 10%;
            border-color: rgba(6, 182, 212, 0.08);
            animation-duration: 17s;
            animation-delay: 5s;
            border-radius: 50% 50% 30% 70% / 70% 30% 50% 50%;
        }

        .shape:nth-child(7) {
            width: 90px;
            height: 90px;
            bottom: 40%;
            left: 15%;
            border-color: rgba(139, 92, 246, 0.06);
            animation-duration: 23s;
            animation-delay: 7s;
            border-radius: 40% 60% 70% 30% / 30% 70% 60% 40%;
        }

        .shape:nth-child(8) {
            width: 110px;
            height: 110px;
            top: 20%;
            left: 50%;
            border-color: rgba(59, 130, 246, 0.06);
            animation-duration: 19s;
            animation-delay: 9s;
            border-radius: 60% 40% 30% 70% / 40% 70% 30% 60%;
        }

        @keyframes float-shape {
            0% {
                transform: translate(0, 0) rotate(0deg) scale(1);
            }
            25% {
                transform: translate(30px, -40px) rotate(90deg) scale(1.1);
            }
            50% {
                transform: translate(-20px, 30px) rotate(180deg) scale(0.9);
            }
            75% {
                transform: translate(40px, 20px) rotate(270deg) scale(1.05);
            }
            100% {
                transform: translate(-30px, -20px) rotate(360deg) scale(0.95);
            }
        }

        /* 2. FULL SCREEN AURORA BOREALIS */
        .aurora {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
            opacity: 0.35;
        }

        .aurora-wave {
            position: absolute;
            width: 200%;
            height: 400px;
            background: linear-gradient(90deg, 
                transparent,
                rgba(6, 182, 212, 0.15),
                rgba(59, 130, 246, 0.2),
                rgba(139, 92, 246, 0.15),
                rgba(6, 182, 212, 0.15),
                transparent
            );
            filter: blur(100px);
            animation: aurora-move 12s ease-in-out infinite alternate;
        }

        .aurora-wave:nth-child(1) {
            top: -80px;
            animation-duration: 14s;
            animation-delay: 0s;
            height: 450px;
        }

        .aurora-wave:nth-child(2) {
            top: 80px;
            animation-duration: 18s;
            animation-delay: 4s;
            height: 380px;
            opacity: 0.6;
            background: linear-gradient(90deg, 
                transparent,
                rgba(139, 92, 246, 0.1),
                rgba(6, 182, 212, 0.15),
                rgba(59, 130, 246, 0.1),
                transparent
            );
        }

        .aurora-wave:nth-child(3) {
            top: 200px;
            animation-duration: 16s;
            animation-delay: 8s;
            height: 320px;
            opacity: 0.4;
            background: linear-gradient(90deg, 
                transparent,
                rgba(244, 63, 94, 0.05),
                rgba(139, 92, 246, 0.1),
                rgba(244, 63, 94, 0.05),
                transparent
            );
        }

        .aurora-wave:nth-child(4) {
            top: 50%;
            animation-duration: 20s;
            animation-delay: 2s;
            height: 250px;
            opacity: 0.3;
            background: linear-gradient(90deg, 
                transparent,
                rgba(251, 191, 36, 0.05),
                rgba(6, 182, 212, 0.1),
                rgba(251, 191, 36, 0.05),
                transparent
            );
        }

        @keyframes aurora-move {
            0% {
                transform: translateX(-20%) translateY(-10%) scale(1);
            }
            50% {
                transform: translateX(10%) translateY(15%) scale(1.2);
            }
            100% {
                transform: translateX(20%) translateY(-5%) scale(0.9);
            }
        }

        /* 3. FULL SCREEN FLOATING ICONS */
        .floating-icons {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .float-icon {
            position: absolute;
            font-size: 24px;
            color: rgba(255, 255, 255, 0.04);
            animation: float-icon 25s linear infinite;
        }

        .float-icon:nth-child(1) {
            top: 8%;
            left: 2%;
            font-size: 32px;
            animation-duration: 28s;
            animation-delay: 0s;
        }

        .float-icon:nth-child(2) {
            top: 15%;
            right: 3%;
            font-size: 22px;
            animation-duration: 22s;
            animation-delay: 5s;
        }

        .float-icon:nth-child(3) {
            bottom: 20%;
            left: 5%;
            font-size: 38px;
            animation-duration: 30s;
            animation-delay: 10s;
        }

        .float-icon:nth-child(4) {
            bottom: 10%;
            right: 2%;
            font-size: 26px;
            animation-duration: 26s;
            animation-delay: 15s;
        }

        .float-icon:nth-child(5) {
            top: 45%;
            left: 1%;
            font-size: 30px;
            animation-duration: 24s;
            animation-delay: 20s;
        }

        .float-icon:nth-child(6) {
            top: 35%;
            right: 1%;
            font-size: 20px;
            animation-duration: 32s;
            animation-delay: 8s;
        }

        .float-icon:nth-child(7) {
            top: 75%;
            left: 12%;
            font-size: 28px;
            animation-duration: 27s;
            animation-delay: 12s;
        }

        .float-icon:nth-child(8) {
            top: 60%;
            right: 8%;
            font-size: 24px;
            animation-duration: 29s;
            animation-delay: 18s;
        }

        @keyframes float-icon {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 0.15;
            }
            25% {
                transform: translateY(-120px) rotate(5deg) scale(1.1);
                opacity: 0.35;
            }
            50% {
                transform: translateY(60px) rotate(-5deg) scale(0.9);
                opacity: 0.15;
            }
            75% {
                transform: translateY(-90px) rotate(3deg) scale(1.05);
                opacity: 0.25;
            }
            100% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 0.15;
            }
        }

        /* 4. FULL SCREEN BURST PARTICLES */
        .burst-container {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .burst {
            position: absolute;
            width: 4px;
            height: 4px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.3), transparent);
            border-radius: 50%;
            animation: burst-particle 6s ease-out infinite;
        }

        .burst:nth-child(1) {
            top: 10%;
            left: 15%;
            animation-delay: 0s;
            width: 6px;
            height: 6px;
        }

        .burst:nth-child(2) {
            top: 25%;
            right: 20%;
            animation-delay: 2s;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.25), transparent);
        }

        .burst:nth-child(3) {
            bottom: 20%;
            left: 25%;
            animation-delay: 4s;
            width: 8px;
            height: 8px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2), transparent);
        }

        .burst:nth-child(4) {
            bottom: 30%;
            right: 15%;
            animation-delay: 1s;
            background: radial-gradient(circle, rgba(244, 63, 94, 0.15), transparent);
        }

        .burst:nth-child(5) {
            top: 45%;
            left: 3%;
            animation-delay: 3s;
            width: 10px;
            height: 10px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.15), transparent);
        }

        .burst:nth-child(6) {
            top: 55%;
            right: 5%;
            animation-delay: 5s;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.2), transparent);
        }

        .burst:nth-child(7) {
            top: 75%;
            left: 8%;
            animation-delay: 2.5s;
            width: 7px;
            height: 7px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.2), transparent);
        }

        .burst:nth-child(8) {
            top: 85%;
            right: 12%;
            animation-delay: 4.5s;
            width: 5px;
            height: 5px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2), transparent);
        }

        @keyframes burst-particle {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            50% {
                transform: translate(-60px, -100px) scale(8);
                opacity: 0.5;
            }
            100% {
                transform: translate(40px, 120px) scale(15);
                opacity: 0;
            }
        }

        /* 5. FULL SCREEN GLOWING ORBS WITH TRAIL */
        .orb-trail {
            position: fixed;
            pointer-events: none;
            z-index: 0;
            border-radius: 50%;
            filter: blur(120px);
            animation: orb-trail 20s ease-in-out infinite alternate;
        }

        .orb-trail:nth-child(1) {
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.2), transparent 70%);
            top: -120px;
            left: -120px;
            animation-duration: 25s;
        }

        .orb-trail:nth-child(2) {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.15), transparent 70%);
            bottom: -100px;
            right: -100px;
            animation-duration: 20s;
            animation-delay: 5s;
        }

        .orb-trail:nth-child(3) {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12), transparent 70%);
            top: 35%;
            left: 45%;
            animation-duration: 22s;
            animation-delay: 10s;
        }

        .orb-trail:nth-child(4) {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(244, 63, 94, 0.08), transparent 70%);
            bottom: 40%;
            right: 30%;
            animation-duration: 28s;
            animation-delay: 15s;
        }

        .orb-trail:nth-child(5) {
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.06), transparent 70%);
            top: 10%;
            right: 35%;
            animation-duration: 24s;
            animation-delay: 20s;
        }

        @keyframes orb-trail {
            0% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(100px, -80px) scale(1.2);
            }
            50% {
                transform: translate(-70px, 70px) scale(0.8);
            }
            75% {
                transform: translate(80px, 50px) scale(1.1);
            }
            100% {
                transform: translate(-60px, -40px) scale(0.9);
            }
        }

        /* 6. FULL SCREEN TWINKLING STARS */
        .stars {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .star {
            position: absolute;
            border-radius: 50%;
            background: white;
            animation: twinkle ease-in-out infinite alternate;
        }

        @keyframes twinkle {
            0% {
                opacity: 0.1;
                transform: scale(0.5);
            }
            100% {
                opacity: 0.8;
                transform: scale(1.3);
            }
        }

        /* 7. SCANLINES (Subtle Full Screen) */
        .scanlines {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0, 0, 0, 0.02) 2px,
                rgba(0, 0, 0, 0.02) 4px
            );
            opacity: 0.4;
        }

        /* 8. VIGNETTE EFFECT */
        .vignette {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(ellipse at center, transparent 50%, rgba(0, 0, 0, 0.3) 100%);
        }

        /* ============================================
           MAIN CARD
           ============================================ */

        .login-card {
            width: 450px;
            background: rgba(12, 15, 35, .85);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 30px;
            padding: 45px 40px 35px;
            color: white;
            box-shadow: 0 30px 100px rgba(0, 0, 0, .7), inset 0 1px 0 rgba(255, 255, 255, .05);
            position: relative;
            z-index: 1;
            animation: slide-up 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            transform: translateY(30px);
            opacity: 0;
            overflow: hidden;
        }

        .login-card::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 32px;
            background: linear-gradient(90deg, 
                #06b6d4, 
                #3b82f6, 
                #8b5cf6, 
                #f43f5e,
                #fbbf24,
                #06b6d4
            );
            background-size: 400% 100%;
            z-index: -1;
            animation: border-glow 8s linear infinite;
            opacity: 0.4;
        }

        @keyframes border-glow {
            0% { background-position: 0% 50%; }
            100% { background-position: 400% 50%; }
        }

        @keyframes slide-up {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 30px;
            background: radial-gradient(circle at 30% 20%, rgba(6, 182, 212, 0.05), transparent 60%),
                        radial-gradient(circle at 70% 80%, rgba(139, 92, 246, 0.05), transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .logo {
            text-align: center;
            font-size: 50px;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6, #8b5cf6, #f43f5e);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-logo 4s ease-in-out infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes gradient-logo {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        h2 {
            text-align: center;
            font-weight: 800;
            font-size: 28px;
            margin-bottom: 4px;
            background: linear-gradient(90deg, #fff, #93c5fd, #c4b5fd, #fff);
            background-size: 300% 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer-text 4s ease-in-out infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes shimmer-text {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        p {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 25px;
            font-size: 14px;
            position: relative;
            z-index: 1;
        }

        /* Inputs */
        .input-group {
            position: relative;
            margin-bottom: 16px;
            z-index: 1;
        }

        .input-group-text {
            background: rgba(255, 255, 255, .05);
            color: rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, .05);
            border-right: none;
            border-radius: 14px 0 0 14px;
            transition: all 0.3s ease;
            padding: 0 16px;
            min-width: 48px;
            justify-content: center;
            font-size: 16px;
        }

        .form-control {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .05);
            border-left: none;
            color: white;
            height: 52px;
            border-radius: 0 14px 14px 0;
            transition: all 0.3s ease;
            padding: 0 16px;
            font-size: 15px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.25);
            font-size: 14px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, .08);
            color: white;
            box-shadow: none;
            border-color: #06b6d4;
        }

        .input-group:focus-within .input-group-text {
            background: rgba(6, 182, 212, 0.12);
            border-color: #06b6d4;
            color: #06b6d4;
        }

        .input-group:focus-within .form-control {
            border-color: #06b6d4;
        }

        .input-ripple {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6, #8b5cf6);
            transition: all 0.4s ease;
            transform: translateX(-50%);
            border-radius: 2px;
            z-index: 5;
        }

        .input-group:focus-within .input-ripple {
            width: 70%;
        }

        /* Button */
        .btn-login {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            color: white;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            margin-top: 6px;
            z-index: 1;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6, #f43f5e);
            background-size: 200% 200%;
            opacity: 0;
            transition: opacity 0.4s ease;
            border-radius: 14px;
            animation: btn-shimmer 3s ease-in-out infinite;
        }

        @keyframes btn-shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .btn-login:hover::before {
            opacity: 1;
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 50px rgba(6, 182, 212, 0.3);
        }

        .btn-login:active {
            transform: scale(0.97);
        }

        .btn-login span,
        .btn-login i {
            position: relative;
            z-index: 1;
        }

        .btn-login i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }

        .btn-login:hover i {
            transform: translateX(-4px) scale(1.2);
        }

        /* Link */
        a {
            color: #93c5fd;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            transition: width 0.3s ease;
        }

        a:hover::after {
            width: 100%;
        }

        a:hover {
            color: white;
        }

        .text-center.mt-4 {
            position: relative;
            padding-top: 4px;
            z-index: 1;
        }

        .text-center.mt-4::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 20%;
            right: 20%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.06), transparent);
        }

        /* Alert */
        .alert {
            border-radius: 12px;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            font-size: 14px;
            padding: 12px 16px;
            backdrop-filter: blur(8px);
            animation: shake 0.5s ease;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        .alert-success {
            background: rgba(52, 211, 153, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.15);
            color: #6ee7b7;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-10px); }
            40% { transform: translateX(10px); }
            60% { transform: translateX(-6px); }
            80% { transform: translateX(6px); }
        }

        /* Responsive */
        @media (max-width: 500px) {
            .login-card {
                width: 92%;
                padding: 30px 20px 25px;
                margin: 20px;
            }

            .logo {
                font-size: 38px;
            }

            h2 {
                font-size: 22px;
            }

            .shape,
            .floating-icons,
            .orb-trail {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- ==========================================
         FULL SCREEN PREMIUM EFFECTS
         ========================================== -->

    <!-- 1. Floating Geometric Shapes (8 shapes) -->
    <div class="shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- 2. Aurora Borealis (4 waves) -->
    <div class="aurora">
        <div class="aurora-wave"></div>
        <div class="aurora-wave"></div>
        <div class="aurora-wave"></div>
        <div class="aurora-wave"></div>
    </div>

    <!-- 3. Floating Icons (8 icons) -->
    <div class="floating-icons">
        <i class="fa-solid fa-bag-shopping float-icon"></i>
        <i class="fa-solid fa-gift float-icon"></i>
        <i class="fa-solid fa-cart-shopping float-icon"></i>
        <i class="fa-solid fa-tag float-icon"></i>
        <i class="fa-solid fa-star float-icon"></i>
        <i class="fa-solid fa-box float-icon"></i>
        <i class="fa-solid fa-crown float-icon"></i>
        <i class="fa-solid fa-gem float-icon"></i>
    </div>

    <!-- 4. Burst Particles (8 bursts) -->
    <div class="burst-container">
        <div class="burst"></div>
        <div class="burst"></div>
        <div class="burst"></div>
        <div class="burst"></div>
        <div class="burst"></div>
        <div class="burst"></div>
        <div class="burst"></div>
        <div class="burst"></div>
    </div>

    <!-- 5. Glowing Orbs (5 orbs) -->
    <div class="orb-trail"></div>
    <div class="orb-trail"></div>
    <div class="orb-trail"></div>
    <div class="orb-trail"></div>
    <div class="orb-trail"></div>

    <!-- 6. Twinkling Stars -->
    <div class="stars" id="stars"></div>

    <!-- 7. Scanlines -->
    <div class="scanlines"></div>

    <!-- 8. Vignette Effect -->
    <div class="vignette"></div>

    <!-- ==========================================
         MAIN CARD
         ========================================== -->

    <div class="login-card">

        <div class="logo">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>

        <h2>Welcome Back</h2>
        <p>Login to your NovaCart account</p>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">

            @csrf

            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                <span class="input-ripple"></span>
            </div>

            <div class="input-group mb-4">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                <span class="input-ripple"></span>
            </div>

            <button type="submit" class="btn-login">
                <i class="fa fa-right-to-bracket"></i>
                <span>Login</span>
            </button>

        </form>

        <div class="text-center mt-4">
            Don't have an account?
            <a href="{{ route('register') }}">Register Now</a>
        </div>

    </div>

    <script>
        // ==========================================
        // CREATE STARS (Full Screen)
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            const starsContainer = document.getElementById('stars');
            for (let i = 0; i < 80; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDuration = (Math.random() * 4 + 2) + 's';
                star.style.animationDelay = (Math.random() * 6) + 's';
                star.style.width = (Math.random() * 3 + 1) + 'px';
                star.style.height = star.style.width;
                starsContainer.appendChild(star);
            }
        });

        // ==========================================
        // BUTTON RIPPLE EFFECT
        // ==========================================
        document.querySelector('.btn-login').addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = 100;
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255,255,255,0.2);
                transform: scale(0);
                animation: ripple-effect 0.6s ease-out forwards;
                pointer-events: none;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                z-index: 0;
            `;
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 700);
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple-effect {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>

</body>
</html>