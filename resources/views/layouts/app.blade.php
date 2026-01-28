<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <title>@yield('title', 'ISKAB - Ikatan Santri Kota Bandung')</title>
        <meta name="description" content="@yield('description', 'Ikatan Santri Kota Bandung (ISKAB) - Organisasi santri se-Kota Bandung untuk mempererat silaturahmi dan mengembangkan potensi santri.')">
        <meta name="keywords" content="ISKAB, Ikatan Santri, Bandung, Santri, Pesantren, Organisasi Santri">
        <meta name="author" content="ISKAB">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', 'ISKAB - Ikatan Santri Kota Bandung')">
        <meta property="og:description" content="@yield('description', 'Ikatan Santri Kota Bandung (ISKAB) - Organisasi santri se-Kota Bandung')">
        <meta property="og:image" content="@yield('image', asset('images/iskab-og.jpg'))">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="@yield('title', 'ISKAB - Ikatan Santri Kota Bandung')">
        <meta property="twitter:description" content="@yield('description', 'Ikatan Santri Kota Bandung')">
        <meta property="twitter:image" content="@yield('image', asset('images/iskab-og.jpg'))">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
