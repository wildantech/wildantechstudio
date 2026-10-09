<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#090c0a">
    <meta name="description" content="@yield('description', 'WildanTech Studio - aplikasi, IoT, otomasi, dan undangan digital.')">
    <title>@yield('title', 'WildanTech Studio')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="site-header">
        <div class="container site-nav">
            @hasSection('writing_mode')
                <a class="brand" href="{{ route('readings.index') }}">
            @else
                <a class="brand" href="{{ route('home') }}">
            @endif
                <img class="brand-logo" src="{{ asset('images/logo.png') }}" alt="WildanTech Studio" width="36" height="36" style="width:36px;height:36px;object-fit:contain;border-radius:50%;">
                <span class="brand-copy"><strong>WILDANTECH</strong><small>studio teknologi</small></span>
            </a>
            <nav class="nav-links" aria-label="Navigasi utama">
                @hasSection('writing_mode')
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('home') }}#karya">Karya</a>
                    <a href="{{ route('home') }}#layanan">Layanan</a>
                    <a href="{{ route('readings.index') }}" class="active">Ruang baca</a>
                    <a href="{{ route('studio.invitations') }}">Undangan digital</a>
                @else
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('home') }}#karya">Karya</a>
                    <a href="{{ route('home') }}#layanan">Layanan</a>
                    <a href="{{ route('readings.index') }}" class="{{ request()->routeIs('readings.*') ? 'active' : '' }}">Ruang baca</a>
                    <a href="{{ route('studio.invitations') }}" class="{{ request()->routeIs('studio.invitations') ? 'active' : '' }}">Undangan digital</a>
                @endif
            </nav>
            <div class="nav-actions">
                @auth
                    <a class="button-quiet button-small" href="{{ route('dashboard.index') }}">Dashboard</a>
                    <a class="nav-pill-btn" href="{{ auth()->user()->is_writer ? route('dashboard.writings.index') : route('writers.register') }}">
                        <span>Studio Tulisan</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M7 7h10v10"/></svg>
                    </a>
                @else
                    <a class="nav-pill-btn" href="{{ route('writers.login') }}">
                        <span>Studio Tulisan</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M7 7h10v10"/></svg>
                    </a>
                @endauth
                <button class="nav-theme-btn" type="button" aria-label="Mode tampilan" title="Mode Gelap Aktif">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>
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
            <div style="display:inline-flex;align-items:center;gap:10px;">
                <img src="{{ asset('images/logo.png') }}" alt="WildanTech" width="24" height="24" style="width:24px;height:24px;object-fit:contain;border-radius:50%;background:#ffffff;padding:2px;">
                <span>WildanTech Studio · dibangun oleh Wildan Ulul Aufa</span>
            </div>
            <div class="footer-links">
                <a href="mailto:ulul4ufa@gmail.com">Email</a>
                <a href="https://github.com/wildantech" target="_blank" rel="noopener noreferrer">GitHub</a>
                <a href="https://instagram.com/wildan.tech" target="_blank" rel="noopener noreferrer">Instagram</a>
                <a href="https://wa.me/6281215430648" target="_blank" rel="noopener noreferrer">WhatsApp</a>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
