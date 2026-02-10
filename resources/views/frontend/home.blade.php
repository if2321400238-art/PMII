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
    </style>

    @include('components.home.hero-section')
    @include('components.home.about-section')
    @include('components.home.news-carousel')
    @include('components.home.gallery-section')
    @include('components.home.home-scripts')

@endsection
