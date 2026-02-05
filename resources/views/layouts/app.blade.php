<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ url()->current() }}">

        <title>@yield('title', 'ISKAB - Ikatan Santri Kalimantan Barat')</title>
        <meta name="description" content="@yield('description', 'Ikatan Santri Kalimantan Barat (ISKAB) - Organisasi santri se-Kalimantan Barat untuk mempererat silaturahmi dan mengembangkan potensi santri.')">
        <meta name="keywords" content="@yield('keywords', 'ISKAB, Ikatan Santri, Kalimantan Barat, Santri, Pesantren, Organisasi Santri')">
        <meta name="author" content="ISKAB">

        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', 'ISKAB - Ikatan Santri Kalimantan Barat')">
        <meta property="og:description" content="@yield('description', 'Organisasi santri se-Kalimantan Barat')">
        <meta property="og:image" content="@yield('image', asset('images/iskab-og.jpg'))">
        <meta property="og:locale" content="id_ID">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', 'ISKAB - Ikatan Santri Kalimantan Barat')">
        <meta name="twitter:description" content="@yield('description', 'Organisasi santri se-Kalimantan Barat')">
        <meta name="twitter:image" content="@yield('image', asset('images/iskab-og.jpg'))">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col relative">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="flex-grow" role="main">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </body>
</html>
