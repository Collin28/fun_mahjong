<header class="header">
    <nav class="navbar">
        <ul class="nav-left">
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" @if(request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
            </li>
            <li>
                <a href="{{ route('home') }}#leaderboard">Papan Peringkat</a>
            </li>
            <li>
                <a href="{{ route('home') }}#rules">Aturan</a>
            </li>
            <li>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" @if(request()->routeIs('about')) aria-current="page" @endif>Tentang Kami</a>
            </li>
        </ul>

        <div class="nav-brand">
            <a href="{{ route('home') }}" class="logo" @if(request()->routeIs('home')) aria-current="page" @endif>
                <img src="/assets/logo.png" alt="FUN MAHJONG, kembali ke beranda" class="logo-img" width="132" height="44">
            </a>
        </div>

        <div class="nav-right">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'nav-link active' : 'nav-link' }}" @if(request()->routeIs('user.dashboard')) aria-current="page" @endif>Dashboard</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="nav-logout-form">
                    @csrf
                    <button type="submit" class="btn-book">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'nav-link active' : 'nav-link' }}" @if(request()->routeIs('login')) aria-current="page" @endif>Masuk</a>
                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'nav-link active' : 'nav-link' }}" @if(request()->routeIs('register')) aria-current="page" @endif>Daftar</a>
                <a href="https://lynk.id/fun_mahjong" class="btn-book" target="_blank" rel="noopener">Pesan Permainan</a>
            @endauth
        </div>

        <button type="button" class="nav-toggle" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobile-menu">
            <span class="bar bar-1"></span>
            <span class="bar bar-2"></span>
            <span class="bar bar-3"></span>
        </button>
    </nav>

    <div class="mobile-menu" id="mobile-menu" inert>
        <ul class="mobile-nav-links">
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" @if(request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
            </li>
            <li>
                <a href="{{ route('home') }}#leaderboard">Papan Peringkat</a>
            </li>
            <li>
                <a href="{{ route('home') }}#rules">Aturan</a>
            </li>
            <li>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" @if(request()->routeIs('about')) aria-current="page" @endif>Tentang Kami</a>
            </li>
        </ul>

        <div class="mobile-auth">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="mobile-auth-link">Dashboard Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="mobile-auth-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" @if(request()->routeIs('user.dashboard')) aria-current="page" @endif>Dashboard</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-book mobile-logout-btn">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-auth-link {{ request()->routeIs('login') ? 'active' : '' }}" @if(request()->routeIs('login')) aria-current="page" @endif>Masuk</a>
                <a href="{{ route('register') }}" class="mobile-auth-link {{ request()->routeIs('register') ? 'active' : '' }}" @if(request()->routeIs('register')) aria-current="page" @endif>Daftar</a>
                <a href="https://lynk.id/fun_mahjong" class="btn-book" target="_blank" rel="noopener">Pesan Permainan</a>
            @endauth
        </div>
    </div>
</header>

<script>
    (function () {
        var header = document.querySelector('.header');
        var toggle = document.querySelector('.nav-toggle');
        var menu = document.getElementById('mobile-menu');
        if (!header || !toggle || !menu) return;

        var mobileQuery = window.matchMedia('(max-width: 992px)');

        function setOpen(open) {
            header.classList.toggle('open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            // inert keeps the closed menu out of the tab order entirely
            if (open) {
                menu.removeAttribute('inert');
            } else {
                menu.setAttribute('inert', '');
            }
        }

        function closeMenu(returnFocus) {
            if (!header.classList.contains('open')) return;
            setOpen(false);
            if (returnFocus) toggle.focus();
        }

        toggle.addEventListener('click', function () {
            setOpen(!header.classList.contains('open'));
        });

        document.addEventListener('click', function (e) {
            if (!header.contains(e.target)) closeMenu(false);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMenu(true);
        });

        menu.addEventListener('click', function (e) {
            if (e.target.closest('a, button')) closeMenu(false);
        });

        // Above the mobile breakpoint the menu is hidden by CSS, so keep it inert there too.
        function syncToViewport() {
            if (mobileQuery.matches) {
                if (!header.classList.contains('open')) menu.setAttribute('inert', '');
            } else {
                closeMenu(false);
                menu.setAttribute('inert', '');
            }
        }

        if (mobileQuery.addEventListener) {
            mobileQuery.addEventListener('change', syncToViewport);
        } else if (mobileQuery.addListener) {
            mobileQuery.addListener(syncToViewport);
        }

        syncToViewport();
    })();
</script>