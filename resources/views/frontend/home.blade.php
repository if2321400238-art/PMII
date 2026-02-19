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
