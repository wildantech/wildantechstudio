<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#090c0a">
    <meta name="description" content="WildanTech Studio - aplikasi, IoT, otomasi, dan undangan digital.">
    <title>@yield('title', 'WildanTech Studio')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="site-header">
        <div class="container site-nav">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark" aria-hidden="true">WT</span>
                <span class="brand-copy"><strong>WILDANTECH</strong><small>studio teknologi</small></span>
            </a>
            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="{{ route('home') }}#karya">Karya</a>
                <a href="{{ route('home') }}#layanan">Layanan</a>
                <a href="{{ route('studio.invitations') }}">Undangan digital</a>
                <a href="{{ route('home') }}#tentang">Studio</a>
            </nav>
            <div class="nav-actions">
                @auth
                    <a class="button-quiet button-small" href="{{ route('dashboard.index') }}">Dashboard</a>
                @else
                    <a class="button-quiet button-small" href="{{ route('login') }}">Masuk</a>
                    <a class="button button-small" href="{{ route('register') }}">Mulai</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="site-main">
        <div class="container">
            @include('partials.flash')
        </div>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-row">
            <span>WildanTech Studio · dibangun oleh Wildan Ulul Aufa</span>
            <div class="footer-links">
                <a href="mailto:ulul4ufa@gmail.com">Email</a>
                <a href="https://github.com/wildantech" target="_blank" rel="noopener noreferrer">GitHub</a>
                <a href="https://instagram.com/wil.dan.ulul" target="_blank" rel="noopener noreferrer">Instagram</a>
                <a href="https://wa.me/6281215430648" target="_blank" rel="noopener noreferrer">WhatsApp</a>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
