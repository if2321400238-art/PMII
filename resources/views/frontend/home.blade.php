@extends('layouts.app')
@section('title', 'Beranda - PMII Komisariat Universitas Nurul Jadid')
@section('description', 'Website resmi PMII Komisariat Universitas Nurul Jadid. Pergerakan Mahasiswa Islam Indonesia
    yang berafiliasi dengan Nahdlatul Ulama (NU), membentuk kader intelektual yang religius dan kritis.')
@section('keywords', 'PMII, PMII UNUJA, Pergerakan Mahasiswa Islam Indonesia, Universitas Nurul Jadid, Mahasiswa Islam,
    NU, Nahdlatul Ulama')

@section('home-section')
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 5px rgba(234, 179, 8, 0.4);
            }

            50% {
                box-shadow: 0 0 10px rgba(234, 179, 8, 0.6);
            }
        }

        @keyframes float-p {
            0% {
                transform: translateX(-6px);
            }

            50% {
                transform: translateX(6px);
            }

            100% {
                transform: translateX(-6px);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(10px);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out forwards;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out forwards;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-float-p {
            animation: float-p 3s ease-in-out infinite;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        .opacity-0-start {
            opacity: 0;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .premium-section {
            position: relative;
            isolation: isolate;
        }

        .premium-section::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(circle at top center, rgba(255,255,255,0.22), transparent 58%);
            opacity: 0.85;
            z-index: -1;
        }

        .premium-title {
            letter-spacing: 0.01em;
            text-wrap: balance;
        }

        .premium-title::after {
            content: "";
            display: block;
            width: 76px;
            height: 3px;
            border-radius: 9999px;
            margin: 12px auto 0;
            background: linear-gradient(to right, rgba(250, 204, 21, 0.95), rgba(59, 130, 246, 0.95));
        }

        .premium-elevated {
            border: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.18);
        }

        .news-pinboard-section {
            background: #ffffff;
        }

        .news-pinboard-section.premium-section::before {
            opacity: 0;
        }

        .news-pinboard-section .premium-title::after {
            background: linear-gradient(to right, rgba(37, 99, 235, 0.92), rgba(245, 158, 11, 0.88));
        }

        .news-pinboard-stage {
            position: relative;
            padding-bottom: 4px;
            isolation: isolate;
        }

        .news-pinboard-stage::before {
            content: "";
            position: absolute;
            inset: 10px;
            border-radius: 30px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background:
                radial-gradient(circle at 14% 14%, rgba(59, 130, 246, 0.2), transparent 42%),
                radial-gradient(circle at 84% 80%, rgba(245, 158, 11, 0.2), transparent 40%),
                repeating-linear-gradient(
                    90deg,
                    rgba(15, 23, 42, 0.04) 0,
                    rgba(15, 23, 42, 0.04) 1px,
                    transparent 1px,
                    transparent 58px
                ),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.46), rgba(255, 255, 255, 0.12)),
                #f5f6fa;
            z-index: 0;
            pointer-events: none;
        }

        .news-pinboard-rope {
            position: absolute;
            z-index: 1;
            border-top: 2px dashed rgba(30, 41, 59, 0.34);
            border-radius: 9999px;
            opacity: 0.88;
            pointer-events: none;
        }

        .news-pinboard-card {
            position: absolute;
            --tilt: 0deg;
            --scroll-swing: 0deg;
            transform-origin: 50% -10px;
            transform: rotate(calc(var(--tilt) + var(--scroll-swing)));
            cursor: pointer;
            z-index: 4;
            transition: transform 140ms ease-out, box-shadow 220ms ease;
            box-shadow: none;
        }

        .news-pinboard-card:hover {
            transform: translateY(-4px) rotate(calc(var(--tilt) + var(--scroll-swing)));
        }

        .news-card-pin {
            position: absolute;
            top: -11px;
            left: 50%;
            width: 21px;
            height: 21px;
            transform: translateX(-50%);
            border-radius: 9999px;
            border: 2px solid rgba(255, 255, 255, 0.94);
            background: radial-gradient(circle at 35% 28%, #f8fafc 0%, #dbe4f2 32%, #64748b 72%, #475569 100%);
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.32);
            z-index: 7;
        }

        .news-card-pin::after {
            content: "";
            position: absolute;
            inset: 50% auto auto 50%;
            width: 6px;
            height: 6px;
            transform: translate(-50%, -50%);
            border-radius: 9999px;
            background: rgba(30, 41, 59, 0.54);
        }

        .news-card-sheet {
            position: relative;
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid rgba(203, 213, 225, 0.75);
            overflow: hidden;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.22);
        }

        .news-card-sheet::after {
            content: "";
            position: absolute;
            inset: 9px;
            border-radius: 12px;
            border: 1px dashed rgba(148, 163, 184, 0.38);
            pointer-events: none;
        }

        .news-card-media {
            overflow: hidden;
        }

        @media (max-width: 767px) {
            .news-pinboard-stage {
                min-height: 780px;
            }

            .news-pinboard-rope.rope-a {
                top: 175px;
                left: 34%;
                width: 122px;
                transform: rotate(-23deg);
            }

            .news-pinboard-rope.rope-b {
                top: 425px;
                left: 38%;
                width: 122px;
                transform: rotate(65deg);
            }

            .news-pinboard-rope.rope-c {
                top: 632px;
                left: 28%;
                width: 154px;
                transform: rotate(-18deg);
            }

            .news-pinboard-card {
                width: 46%;
                max-width: 170px;
            }

            .news-pinboard-card.pin-a {
                top: 164px;
                left: 10px;
                --tilt: -8deg;
            }

            .news-pinboard-card.pin-b {
                top: 94px;
                right: 10px;
                --tilt: 8deg;
            }

            .news-pinboard-card.pin-c {
                top: 374px;
                right: 22px;
                --tilt: -7deg;
            }

            .news-pinboard-card.pin-d {
                top: 560px;
                left: 12px;
                --tilt: 7deg;
            }

            .news-card-media {
                height: 84px;
            }
        }

        @media (min-width: 768px) {
            .news-pinboard-stage {
                min-height: 760px;
            }

            .news-pinboard-rope.rope-a {
                top: 156px;
                left: 34%;
                width: 216px;
                transform: rotate(-20deg);
            }

            .news-pinboard-rope.rope-b {
                top: 356px;
                left: 44%;
                width: 168px;
                transform: rotate(63deg);
            }

            .news-pinboard-rope.rope-c {
                top: 566px;
                left: 29%;
                width: 214px;
                transform: rotate(-18deg);
            }

            .news-pinboard-card {
                width: clamp(208px, 30vw, 272px);
            }

            .news-pinboard-card.pin-a {
                top: 140px;
                left: 8%;
                --tilt: -10deg;
            }

            .news-pinboard-card.pin-b {
                top: 34px;
                right: 9%;
                --tilt: 9deg;
            }

            .news-pinboard-card.pin-c {
                top: 320px;
                right: 14%;
                --tilt: -8deg;
            }

            .news-pinboard-card.pin-d {
                top: 440px;
                left: 8%;
                --tilt: 8deg;
            }

            .news-card-pin {
                top: -13px;
                width: 24px;
                height: 24px;
            }

            .news-card-media {
                height: 132px;
            }
        }

        /* Lightweight reveal system */
        .section-reveal {
            opacity: 0;
            transform: translateY(22px) scale(0.985);
            transition: opacity 560ms cubic-bezier(0.22, 1, 0.36, 1),
                        transform 560ms cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }

        .section-reveal.is-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .card-reveal {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 480ms ease, transform 480ms ease;
            transition-delay: var(--reveal-delay, 0ms);
            will-change: opacity, transform;
        }

        .card-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .subtle-hover {
            transition: transform 240ms ease, box-shadow 240ms ease;
        }

        .subtle-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 36px rgba(15, 23, 42, 0.2);
        }

        @keyframes float-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .float-slow {
            animation: float-slow 8s ease-in-out infinite;
        }

        .premium-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(28px);
            pointer-events: none;
            opacity: 0.32;
            animation: float-slow 10s ease-in-out infinite;
            will-change: transform;
        }

        .premium-orb-a {
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(250, 204, 21, 0.9), rgba(250, 204, 21, 0));
            top: 8%;
            right: 12%;
        }

        .premium-orb-b {
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.9), rgba(59, 130, 246, 0));
            bottom: 8%;
            left: 10%;
            animation-delay: 0.8s;
        }

        .premium-parallax {
            transform: translate3d(var(--px, 0px), var(--py, 0px), 0);
            transition: transform 260ms cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }

        .premium-tilt {
            transform:
                perspective(1000px)
                rotateX(var(--rx, 0deg))
                rotateY(var(--ry, 0deg))
                translateZ(0);
            transition: transform 280ms cubic-bezier(0.22, 1, 0.36, 1);
            transform-style: preserve-3d;
            will-change: transform;
        }

        .cinematic-section {
            opacity: 0;
            transform: translateY(30px);
            filter: blur(4px);
            clip-path: inset(0 0 10% 0 round 20px);
            transition:
                opacity 700ms cubic-bezier(0.22, 1, 0.36, 1),
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                filter 700ms ease,
                clip-path 700ms ease;
            will-change: opacity, transform, filter, clip-path;
        }

        .cinematic-section.is-cinematic-visible {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
            clip-path: inset(0 0 0 0 round 0);
        }

        .parallax-title {
            transform: translate3d(0, var(--parallax-y, 0px), 0);
            will-change: transform;
        }

        @keyframes ken-burns-soft {
            0% { transform: scale(1.02) translate3d(0, 0, 0); }
            50% { transform: scale(1.06) translate3d(-0.7%, -0.6%, 0); }
            100% { transform: scale(1.02) translate3d(0, 0, 0); }
        }

        .hero-slide-active img {
            animation: ken-burns-soft 9s ease-in-out infinite;
            will-change: transform;
        }

        @keyframes cta-shimmer {
            0% { background-position: -220px 0; }
            100% { background-position: 220px 0; }
        }

        .cta-shimmer {
            background-image: linear-gradient(
                115deg,
                rgba(255,255,255,0) 0%,
                rgba(255,255,255,0.22) 42%,
                rgba(255,255,255,0) 74%
            );
            background-size: 220px 100%;
            background-repeat: no-repeat;
            animation: cta-shimmer 2.6s linear infinite;
        }

        .magnetic-hover {
            transform: translate3d(var(--mx, 0px), var(--my, 0px), 0);
            transition: transform 180ms cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }

        @media (prefers-reduced-motion: reduce) {
            .section-reveal,
            .card-reveal,
            .subtle-hover,
            .float-slow {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }

            .hero-slide-active img,
            .cta-shimmer,
            .magnetic-hover,
            .parallax-title,
            .news-pinboard-card,
            .cinematic-section {
                animation: none !important;
                transform: none !important;
                filter: none !important;
                clip-path: none !important;
                opacity: 1 !important;
            }
        }
    </style>

    @include('components.home.hero-section')
    @include('components.home.about-section')
    @include('components.home.news-carousel')
    @include('components.home.gallery-section')
    @include('components.home.home-scripts')

@endsection
