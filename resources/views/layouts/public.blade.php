<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FUN MAHJONG')</title>
    <meta name="description" content="@yield('meta-description', 'Komunitas mahjong di Pontianak. Main santai bersama teman, ikuti papan peringkat mingguan, dan pesan meja bermain kamu.')">
    <link rel="icon" href="/assets/logo.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    @yield('head')
</head>
<body>

    <a href="#main-content" class="skip-link">Lompat ke konten utama</a>

    @include('partials.navbar')

    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    @include('partials.footer')

    @yield('scripts')
</body>
</html>
