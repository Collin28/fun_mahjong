<footer class="footer">
    <div class="footer-container">

        <div class="footer-brand">
            <img src="/assets/logo.png" alt="FUN MAHJONG" class="footer-logo" width="144" height="48">
            <p>Pengalaman bermain mahjong modern dengan suasana santai, komunitas seru, dan sistem peringkat yang kompetitif.</p>
        </div>

        <div class="footer-column">
            <h4>Navigasi</h4>
            <ul class="footer-links">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('home') }}#leaderboard">Papan Peringkat</a></li>
                <li><a href="{{ route('home') }}#rules">Aturan Main</a></li>
                <li><a href="{{ route('about') }}">Tentang Kami</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Layanan</h4>
            <ul class="footer-links">
                <li><a href="{{ route('login') }}">Masuk Akun</a></li>
                <li><a href="{{ route('register') }}">Daftar Member</a></li>
                <li><a href="https://lynk.id/fun_mahjong" target="_blank" rel="noopener">Pesan Meja</a></li>
            </ul>
        </div>

        <div class="footer-column footer-contact">
            <h4>Lokasi &amp; Kontak</h4>
            <p><span aria-hidden="true">📍</span> Pontianak, Indonesia</p>
            {{--
                TODO: ganti dengan nomor WhatsApp & email asli, lalu aktifkan blok di bawah.
                Nomor/email contoh sengaja tidak ditampilkan agar tidak menyesatkan pengunjung.
                <p><a href="https://wa.me/62XXXXXXXXXXX">WhatsApp</a></p>
                <p><a href="mailto:halo@domainasli.com">halo@domainasli.com</a></p>
            --}}
            <p><a href="https://lynk.id/fun_mahjong" target="_blank" rel="noopener">Hubungi kami lewat Lynk.id</a></p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} FUN MAHJONG. Hak cipta dilindungi.</p>
        <p>Dibuat untuk main seru dan sportif</p>
    </div>
</footer>