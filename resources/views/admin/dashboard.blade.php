@extends('layouts.admin')

@section('content')

<style>
    /* ===========================
       Dashboard - Ultra Premium with Glassmorphism
    =========================== */

    .dashboard {
        padding: 24px 30px 30px;
        animation: fadeIn .8s ease;
        background: linear-gradient(135deg, #eef2ff 0%, #f0f4ff 30%, #f8fafc 60%, #f1f5f9 100%);
        min-height: 100vh;
        max-height: 100vh;
        overflow: hidden;
        position: relative;
    }

    /* Animated Background Gradient */
    .dashboard::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 20% 50%, rgba(99, 102, 241, 0.04) 0%, transparent 50%),
                    radial-gradient(ellipse at 80% 50%, rgba(139, 92, 246, 0.04) 0%, transparent 50%),
                    radial-gradient(ellipse at 50% 20%, rgba(59, 130, 246, 0.02) 0%, transparent 40%);
        pointer-events: none;
        animation: bg-pulse 10s ease-in-out infinite alternate;
    }

    @keyframes bg-pulse {
        0% { opacity: 0.5; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.05); }
        100% { opacity: 0.5; transform: scale(1); }
    }

    /* Floating Glass Orbs - More & Brighter */
    .glass-orb {
        position: fixed;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        animation: glass-float 25s ease-in-out infinite alternate;
    }

    .glass-orb:nth-child(1) {
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.08), transparent 70%);
        top: -150px;
        right: -150px;
        animation-delay: 0s;
        filter: blur(80px);
    }

    .glass-orb:nth-child(2) {
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.06), transparent 70%);
        bottom: -100px;
        left: -100px;
        animation-delay: 5s;
        filter: blur(80px);
    }

    .glass-orb:nth-child(3) {
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.05), transparent 70%);
        top: 30%;
        left: 45%;
        animation-delay: 10s;
        filter: blur(80px);
    }

    .glass-orb:nth-child(4) {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.04), transparent 70%);
        bottom: 30%;
        right: 20%;
        animation-delay: 15s;
        filter: blur(80px);
    }

    .glass-orb:nth-child(5) {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.03), transparent 70%);
        top: 60%;
        right: 40%;
        animation-delay: 20s;
        filter: blur(80px);
    }

    @keyframes glass-float {
        0% { transform: translate(0, 0) scale(1) rotate(0deg); }
        25% { transform: translate(80px, -60px) scale(1.15) rotate(5deg); }
        50% { transform: translate(-60px, 40px) scale(0.85) rotate(-5deg); }
        75% { transform: translate(50px, 30px) scale(1.1) rotate(3deg); }
        100% { transform: translate(-40px, -50px) scale(0.95) rotate(-3deg); }
    }

    /* Sparkle Particles */
    .sparkle-container {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
    }

    .sparkle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: white;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
        animation: sparkle-fly 15s linear infinite;
        opacity: 0;
    }

    .sparkle:nth-child(1) { left: 10%; top: 20%; animation-delay: 0s; }
    .sparkle:nth-child(2) { left: 25%; top: 60%; animation-delay: 3s; width: 6px; height: 6px; }
    .sparkle:nth-child(3) { left: 60%; top: 15%; animation-delay: 6s; }
    .sparkle:nth-child(4) { left: 75%; top: 70%; animation-delay: 9s; width: 3px; height: 3px; }
    .sparkle:nth-child(5) { left: 45%; top: 40%; animation-delay: 12s; width: 5px; height: 5px; }
    .sparkle:nth-child(6) { left: 85%; top: 30%; animation-delay: 4s; }
    .sparkle:nth-child(7) { left: 5%; top: 80%; animation-delay: 7s; width: 7px; height: 7px; }
    .sparkle:nth-child(8) { left: 50%; top: 85%; animation-delay: 10s; }

    @keyframes sparkle-fly {
        0% {
            transform: translate(0, 0) scale(0);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        50% {
            transform: translate(100px, -200px) scale(1.5);
            opacity: 0.8;
        }
        80% {
            opacity: 0.5;
        }
        100% {
            transform: translate(200px, -400px) scale(0);
            opacity: 0;
        }
    }

    /* ===========================
       Welcome Card - Glassmorphism with Glow
    =========================== */

    .welcome-card {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 32px 45px;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.95) 0%, rgba(124, 58, 237, 0.95) 50%, rgba(109, 40, 217, 0.95) 100%);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        color: #fff;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(79, 70, 229, .35), inset 0 1px 0 rgba(255,255,255,0.15);
        margin-bottom: 28px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        min-height: 140px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .welcome-card:hover {
        transform: translateY(-4px) scale(1.005);
        box-shadow: 0 35px 80px rgba(79, 70, 229, .45), inset 0 1px 0 rgba(255,255,255,0.2);
    }

    /* Glow Ring Effect */
    .welcome-card .glow-ring {
        position: absolute;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.05);
        animation: ring-spin 20s linear infinite;
        pointer-events: none;
    }

    .welcome-card .glow-ring:nth-child(4) {
        width: 300px;
        height: 300px;
        right: -50px;
        top: -80px;
        animation-duration: 25s;
        border-color: rgba(255, 215, 0, 0.06);
    }

    .welcome-card .glow-ring:nth-child(5) {
        width: 200px;
        height: 200px;
        left: -30px;
        bottom: -50px;
        animation-duration: 18s;
        animation-direction: reverse;
        border-color: rgba(255, 255, 255, 0.04);
    }

    @keyframes ring-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .welcome-card .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        animation: orb-float 12s ease-in-out infinite alternate;
    }

    .welcome-card .orb-1 {
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        right: -80px;
        top: -100px;
        animation-delay: 0s;
    }

    .welcome-card .orb-2 {
        width: 220px;
        height: 220px;
        background: rgba(255, 215, 0, 0.06);
        left: -60px;
        bottom: -80px;
        animation-delay: 4s;
        animation-duration: 14s;
    }

    .welcome-card .orb-3 {
        width: 180px;
        height: 180px;
        background: rgba(255, 255, 255, 0.05);
        right: 30%;
        top: 20%;
        animation-delay: 8s;
        animation-duration: 16s;
    }

    @keyframes orb-float {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(50px, -40px) scale(1.3); }
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 30%, transparent 70%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.12);
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        animation: badge-pulse 3s ease-in-out infinite;
    }

    @keyframes badge-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.03); box-shadow: 0 0 30px rgba(255,255,255,0.1); }
    }

    .welcome-badge i {
        font-size: 13px;
        animation: sparkle 3s ease-in-out infinite;
    }

    @keyframes sparkle {
        0%, 100% { transform: scale(1) rotate(0deg); }
        50% { transform: scale(1.5) rotate(180deg); }
    }

    .welcome-content h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 6px;
        line-height: 1.2;
        animation: text-shimmer 4s ease-in-out infinite;
        background: linear-gradient(90deg, #fff, #fde68a, #fff, #fde68a, #fff);
        background-size: 400% 100%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @keyframes text-shimmer {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .welcome-content h2 span {
        -webkit-text-fill-color: #fde68a;
        background: none;
    }

    .welcome-content p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.85);
        opacity: 0.9;
        margin-bottom: 0;
        animation: fade-slide 1s ease forwards;
    }

    @keyframes fade-slide {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .welcome-icon {
        position: relative;
        z-index: 2;
        flex-shrink: 0;
        margin-left: 20px;
    }

    .icon-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 2px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .icon-circle::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255,255,255,0.3), transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .welcome-card:hover .icon-circle::before {
        opacity: 1;
    }

    .icon-circle i {
        font-size: 42px;
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.1));
        animation: icon-float 4s ease-in-out infinite;
    }

    @keyframes icon-float {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-10px) scale(1.08); }
    }

    .welcome-card:hover .icon-circle {
        transform: rotate(10deg) scale(1.08);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .welcome-card:hover .icon-circle i {
        transform: scale(1.1) rotate(-10deg);
        animation: none;
    }

    /* ===========================
       Stats Grid - Glassmorphism
    =========================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 22px 24px;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 20px;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.04), inset 0 1px 0 rgba(255,255,255,0.8);
        border: 1px solid rgba(255, 255, 255, 0.3);
        cursor: pointer;
        min-height: 100px;
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        transition: height 0.4s ease;
    }

    .stat-card:hover::before {
        height: 5px;
    }

    .blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa, #93c5fd); }
    .purple::before { background: linear-gradient(90deg, #6366f1, #8b5cf6, #a78bfa); }
    .green::before { background: linear-gradient(90deg, #10b981, #34d399, #6ee7b7); }
    .yellow::before { background: linear-gradient(90deg, #f59e0b, #fbbf24, #fcd34d); }

    /* Glass Shine */
    .stat-card::after {
        content: "";
        position: absolute;
        top: -150%;
        left: -45%;
        width: 45%;
        height: 320%;
        background: rgba(255, 255, 255, 0.15);
        transform: rotate(25deg);
        transition: 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }

    .stat-card:hover::after {
        left: 135%;
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08), 0 8px 25px rgba(79, 70, 229, 0.08);
        border-color: rgba(79, 70, 229, 0.15);
        background: rgba(255, 255, 255, 0.8);
    }

    .stat-card .icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        flex-shrink: 0;
        position: relative;
        animation: icon-pulse 3s ease-in-out infinite;
    }

    @keyframes icon-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }

    .stat-card:hover .icon {
        transform: rotate(8deg) scale(1.12);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        animation: none;
    }

    .bg-blue { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .bg-purple { background: linear-gradient(135deg, #6366f1, #4338ca); }
    .bg-green { background: linear-gradient(135deg, #10b981, #059669); }
    .bg-yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .stat-content {
        flex: 1;
        min-width: 0;
    }

    .stat-content h5 {
        margin: 0;
        color: #6b7280;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .stat-content h2 {
        margin: 2px 0 0;
        font-size: 32px;
        font-weight: 800;
        color: #111827;
        letter-spacing: -1px;
        line-height: 1.1;
        animation: number-pop 0.6s ease forwards;
    }

    @keyframes number-pop {
        from { opacity: 0; transform: scale(0.5) rotate(-10deg); }
        to { opacity: 1; transform: scale(1) rotate(0deg); }
    }

    /* ===========================
       Recent Activity - All Activities with Scroll
    =========================== */

    .recent-activity {
        background: rgba(255, 255, 255, 0.55);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 24px 28px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.04), inset 0 1px 0 rgba(255,255,255,0.8);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        width: 100%;
        flex: 1;
        min-height: 300px;
    }

    .recent-activity:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        background: rgba(255, 255, 255, 0.7);
        transform: translateY(-2px);
    }

    .recent-activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        border-bottom: 1px solid rgba(241, 245, 249, 0.5);
        padding-bottom: 12px;
    }

    .recent-activity h4 {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .recent-activity h4 i {
        color: #6366f1;
        font-size: 18px;
        animation: spin-slow 8s linear infinite;
    }

    @keyframes spin-slow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .activity-badge {
        font-size: 11px;
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
        padding: 2px 12px;
        border-radius: 20px;
        font-weight: 600;
    }

    /* ✅ FIXED: ALL ACTIVITIES WITH SCROLL */
    .activity-list {
        max-height: 280px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 4px;
    }

    .activity-list::-webkit-scrollbar {
        width: 5px;
    }

    .activity-list::-webkit-scrollbar-track {
        background: rgba(241, 245, 249, 0.5);
        border-radius: 10px;
    }

    .activity-list::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #6366f1, #8b5cf6, #a78bfa);
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
    }

    .activity-list::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #4f46e5, #7c3aed);
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(241, 245, 249, 0.3);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .activity-item:first-child {
        padding-top: 0;
    }

    .activity-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 0;
        background: linear-gradient(180deg, #6366f1, #8b5cf6, #a78bfa);
        transition: height 0.3s ease;
        border-radius: 0 3px 3px 0;
    }

    .activity-item:hover::before {
        height: 100%;
    }

    .activity-item:hover {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 8px;
        padding: 10px 12px;
        margin: 0 -8px;
        border-bottom-color: transparent;
        width: calc(100% + 16px);
        transform: translateX(4px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .activity-item:last-child:hover {
        padding-bottom: 10px;
    }

    .activity-icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
        min-width: 36px;
        transition: all 0.3s ease;
        animation: icon-bounce 2s ease-in-out infinite;
    }

    @keyframes icon-bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .activity-item:hover .activity-icon-wrapper {
        transform: scale(1.15) rotate(5deg);
        animation: none;
    }

    .activity-icon-wrapper.order {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
    }

    .activity-icon-wrapper.product {
        background: rgba(59, 130, 246, 0.12);
        color: #3b82f6;
    }

    .activity-icon-wrapper.customer {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
    }

    .activity-icon-wrapper.system {
        background: rgba(99, 102, 241, 0.12);
        color: #6366f1;
    }

    .activity-icon-wrapper.update {
        background: rgba(139, 92, 246, 0.12);
        color: #8b5cf6;
    }

    .activity-text {
        flex: 1;
        font-size: 13px;
        color: #1e293b;
        font-weight: 500;
        line-height: 1.4;
        min-width: 0;
        word-wrap: break-word;
    }

    .activity-text .highlight {
        font-weight: 700;
        color: #111827;
    }

    .activity-text .highlight-order {
        font-weight: 700;
        color: #059669;
    }

    .activity-text .highlight-product {
        font-weight: 700;
        color: #2563eb;
    }

    .activity-text .highlight-customer {
        font-weight: 700;
        color: #d97706;
    }

    .activity-text .highlight-update {
        font-weight: 700;
        color: #7c3aed;
    }

    .activity-time {
        font-size: 11px;
        color: #94a3b8;
        white-space: nowrap;
        font-weight: 500;
        flex-shrink: 0;
        background: rgba(255, 255, 255, 0.3);
        padding: 2px 10px;
        border-radius: 12px;
        backdrop-filter: blur(5px);
    }

    .no-activity {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }

    .no-activity i {
        font-size: 40px;
        display: block;
        margin-bottom: 12px;
        opacity: 0.3;
        animation: float-icon 3s ease-in-out infinite;
    }

    @keyframes float-icon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .activity-count {
        font-size: 11px;
        color: #94a3b8;
        background: rgba(241, 245, 249, 0.5);
        padding: 2px 12px;
        border-radius: 12px;
    }

    /* ===========================
       Animations
    =========================== */

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stat-card {
        animation: fadeUp 0.6s ease forwards;
        opacity: 0;
    }

    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.2s; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .activity-item {
        animation: slide-in 0.5s ease forwards;
        opacity: 0;
    }

    .activity-item:nth-child(1) { animation-delay: 0.02s; }
    .activity-item:nth-child(2) { animation-delay: 0.04s; }
    .activity-item:nth-child(3) { animation-delay: 0.06s; }
    .activity-item:nth-child(4) { animation-delay: 0.08s; }
    .activity-item:nth-child(5) { animation-delay: 0.10s; }
    .activity-item:nth-child(6) { animation-delay: 0.12s; }
    .activity-item:nth-child(7) { animation-delay: 0.14s; }
    .activity-item:nth-child(8) { animation-delay: 0.16s; }
    .activity-item:nth-child(9) { animation-delay: 0.18s; }
    .activity-item:nth-child(10) { animation-delay: 0.20s; }

    @keyframes slide-in {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* ===========================
       Responsive
    =========================== */

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard {
            padding: 16px;
            max-height: none;
            overflow: visible;
        }

        .welcome-card {
            padding: 24px 20px;
            flex-direction: column;
            text-align: center;
            gap: 20px;
            min-height: auto;
        }

        .welcome-content h2 {
            font-size: 26px;
        }

        .welcome-icon {
            margin-left: 0;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
        }

        .icon-circle i {
            font-size: 34px;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .stat-card {
            padding: 16px 18px;
            min-height: 80px;
            gap: 12px;
        }

        .stat-card .icon {
            width: 48px;
            height: 48px;
            font-size: 18px;
            border-radius: 12px;
        }

        .stat-content h2 {
            font-size: 24px;
        }

        .stat-content h5 {
            font-size: 10px;
        }

        .recent-activity {
            padding: 18px 16px;
            min-height: 250px;
        }

        .activity-text {
            font-size: 12px;
        }

        .activity-list {
            max-height: 200px;
        }

        .glass-orb {
            display: none;
        }

        .sparkle {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .welcome-content h2 {
            font-size: 22px;
        }

        .welcome-card {
            padding: 20px 16px;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
        }

        .icon-circle i {
            font-size: 28px;
        }
    }
</style>

<div class="dashboard">

    <!-- Glass Orbs -->
    <div class="glass-orb"></div>
    <div class="glass-orb"></div>
    <div class="glass-orb"></div>
    <div class="glass-orb"></div>
    <div class="glass-orb"></div>

    <!-- Sparkle Particles -->
    <div class="sparkle-container">
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
    </div>

    <!-- ================= Welcome Card ================= -->
    <div class="welcome-card">

        <div class="glow-ring"></div>
        <div class="glow-ring"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="welcome-content">

            <span class="welcome-badge">
                <i class="fa-solid fa-sparkles"></i>
                NovaCart Dashboard
            </span>

            <h2>
                Welcome Back, <span>{{ auth()->user()->name }}</span> 👋
            </h2>

            <p>
                Here's what's happening with your store today.
            </p>

        </div>

        <div class="welcome-icon">
            <div class="icon-circle">
                <i class="fa-solid fa-store"></i>
            </div>
        </div>

    </div>

    <!-- ================= Stats ================= -->
    <div class="stats-grid">

        <div class="stat-card blue">
            <div class="icon bg-blue">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="stat-content">
                <h5>Total Products</h5>
                <h2>{{ $products ?? 0 }}</h2>
            </div>
        </div>

        <div class="stat-card purple">
            <div class="icon bg-purple">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="stat-content">
                <h5>Total Orders</h5>
                <h2>{{ $orders ?? 0 }}</h2>
            </div>
        </div>

        <div class="stat-card green">
            <div class="icon bg-green">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-content">
                <h5>Total Customers</h5>
                <h2>{{ $customers ?? 0 }}</h2>
            </div>
        </div>

        <div class="stat-card yellow">
            <div class="icon bg-yellow">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h5>Total Revenue</h5>
                <h2>Rs. {{ number_format($revenue ?? 0) }}</h2>
            </div>
        </div>

    </div>

    <!-- ================= Recent Activity - ALL ACTIVITIES ================= -->
    @php
        try {
            $activities = collect();

            // Get ALL recent orders (limit 15 for better display)
            $recentOrders = App\Models\Order::with('user')
                ->latest()
                ->take(15)
                ->get();

            foreach ($recentOrders as $order) {
                $activities->push((object)[
                    'type' => 'order',
                    'icon' => 'fa-solid fa-cart-shopping',
                    'icon_class' => 'order',
                    'message' => 'New order <span class="highlight-order">#' . $order->order_number . '</span> placed by <span class="highlight">' . ($order->user->name ?? 'Guest') . '</span>',
                    'time' => $order->created_at->diffForHumans(),
                    'timestamp' => $order->created_at
                ]);
            }

            // Get ALL recent products
            $recentProducts = App\Models\Product::latest()
                ->take(10)
                ->get();

            foreach ($recentProducts as $product) {
                $activities->push((object)[
                    'type' => 'product',
                    'icon' => 'fa-solid fa-box',
                    'icon_class' => 'product',
                    'message' => 'Product <span class="highlight-product">"' . $product->name . '"</span> added to store',
                    'time' => $product->created_at->diffForHumans(),
                    'timestamp' => $product->created_at
                ]);
            }

            // Get ALL recent customers
            $recentCustomers = App\Models\Customer::latest()
                ->take(10)
                ->get();

            foreach ($recentCustomers as $customer) {
                $activities->push((object)[
                    'type' => 'customer',
                    'icon' => 'fa-solid fa-user-plus',
                    'icon_class' => 'customer',
                    'message' => 'New customer <span class="highlight-customer">"' . $customer->name . '"</span> registered',
                    'time' => $customer->created_at->diffForHumans(),
                    'timestamp' => $customer->created_at
                ]);
            }

            // Get recent order status updates (if any)
            $recentUpdates = App\Models\Order::where('order_status', '!=', 'Pending')
                ->latest()
                ->take(5)
                ->get();

            foreach ($recentUpdates as $update) {
                $activities->push((object)[
                    'type' => 'update',
                    'icon' => 'fa-solid fa-pen-to-square',
                    'icon_class' => 'update',
                    'message' => 'Order <span class="highlight-order">#' . $update->order_number . '</span> status updated to <span class="highlight-update">' . $update->order_status . '</span>',
                    'time' => $update->updated_at->diffForHumans(),
                    'timestamp' => $update->updated_at
                ]);
            }

            // Sort by timestamp descending and take all (no limit)
            $activities = $activities->sortByDesc('timestamp')->values();

        } catch (\Exception $e) {
            $activities = collect();
        }
    @endphp

    <div class="recent-activity">

        <div class="recent-activity-header">
            <h4>
                <i class="fa-solid fa-clock-rotate-left"></i>
                Recent Activity
                <span class="activity-badge">{{ $activities->count() }} activities</span>
            </h4>
        
        </div>

        <div class="activity-list">
            @if($activities->count() > 0)
                @foreach($activities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon-wrapper {{ $activity->icon_class }}">
                            <i class="{{ $activity->icon }}"></i>
                        </div>
                        <span class="activity-text">{!! $activity->message !!}</span>
                        <span class="activity-time">{{ $activity->time }}</span>
                    </div>
                @endforeach
            @else
                <div class="no-activity">
                    <i class="fa-solid fa-inbox"></i>
                    <p>No recent activity found.</p>
                </div>
            @endif
        </div>

    </div>

</div>

@endsection