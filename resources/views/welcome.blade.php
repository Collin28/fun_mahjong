@extends('layouts.public')

@section('title', 'FUN MAHJONG - Beranda')

@section('content')
    <section class="hero">
        <div class="hero-banner-wrapper">
            <div class="banner-card" style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('/assets/banner.jpg');">
                <div class="hero-header-content">
                    <span class="tagline">COMMUNITY & GAMES</span>
                    <h1 class="hero-title">Main Mahjong <span class="highlight-orange">Lebih Seru</span> & <span class="highlight-silver">Kekinian</span></h1>
                    <p class="hero-description">Pengalaman bermain mahjong modern dengan suasana santai, komunitas seru, dan sistem peringkat yang kompetitif.</p>
                    <div class="hero-actions">
                        <a href="https://lynk.id/fun_mahjong" class="btn-hero-cta" target="_blank" rel="noopener">Pesan Meja Sekarang</a>
                        <a href="#rules" class="btn-hero-secondary">Pelajari Cara Bermain</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="marquee-ribbon" aria-hidden="true">
        <div class="marquee-track">
            <span>🀄 FUN MAHJONG COMMUNITY</span>
            <span>🀄 WEEKLY TOURNAMENT</span>
            <span>🀄 BOOK YOUR TABLE NOW</span>
            <span>🀄 FAIR PLAY & FUN TIMES</span>
            <span>🀄 FUN MAHJONG COMMUNITY</span>
            <span>🀄 WEEKLY TOURNAMENT</span>
        </div>
    </div>

    @include('partials.leaderboard-section', [
        'dailyUsers' => $dailyUsers,
        'weeklyUsers' => $weeklyUsers,
        'topPlayers' => $topPlayers,
        'topLoyal' => $topLoyal,
    ])

    <section class="rules-section" id="rules">
        <div class="section-header">
            <div>
                <span class="sub-label">CARA BERMAIN</span>
                <div class="section-title">
                    <h2>Aturan &amp; Perhitungan Poin</h2>
                </div>
            </div>
            <p class="section-desc">Begini cara skor kamu dihitung dan bagaimana posisi di papan peringkat ditentukan.</p>
        </div>

        <div class="rules-layout">
            <div class="rules-scoring">
                <h3 class="rules-subhead">Dua Jenis Kemenangan</h3>

                <div class="score-type">
                    <div class="score-type-head">
                        <span class="score-name">Hu</span>
                        <span class="score-tag">1 poin</span>
                    </div>
                    <p>Menang dengan mengambil kartu buangan dari pemain lain untuk melengkapi susunan kartu kamu.</p>
                </div>

                <div class="score-type">
                    <div class="score-type-head">
                        <span class="score-name">Zi Mo</span>
                        <span class="score-tag">2 poin</span>
                    </div>
                    <p>Menang dengan menarik sendiri kartu penutup dari tumpukan, tanpa bantuan buangan pemain lain.</p>
                </div>

                <p class="rules-formula">
                    <strong>Total Menang</strong> = jumlah Hu + jumlah Zi Mo. Kedua jenis dicatat terpisah, jadi kamu bisa melihat gaya main kamu sendiri.
                </p>
            </div>

            <div class="rules-ranking">
                <h3 class="rules-subhead">Empat Papan Peringkat</h3>

                <dl class="rules-list">
                    <div class="rules-list-row">
                        <dt>Daily Rank</dt>
                        <dd>Diurutkan dari jumlah match yang kamu mainkan hari ini.</dd>
                    </div>
                    <div class="rules-list-row">
                        <dt>Weekly Rank</dt>
                        <dd>Diurutkan dari jumlah match minggu berjalan. Hitungan ini di-reset oleh pengelola di akhir setiap pekan.</dd>
                    </div>
                    <div class="rules-list-row">
                        <dt>Top Players</dt>
                        <dd>Diurutkan dari total poin kemenangan sepanjang waktu (Hu + Zi Mo).</dd>
                    </div>
                    <div class="rules-list-row">
                        <dt>Top Loyal</dt>
                        <dd>Diurutkan dari total sesi bermain, berapa pun hasil menang atau kalahnya.</dd>
                    </div>
                </dl>

                <h3 class="rules-subhead rules-subhead-spaced">Tingkat Loyalty</h3>
                <p class="rules-note">Ditentukan otomatis dari total sesi bermain kamu.</p>

                <ul class="tier-list">
                    <li class="tier-item">
                        <span class="tier-dot tier-dot-diamond" aria-hidden="true"></span>
                        <span class="tier-name">VIP Diamond</span>
                        <span class="tier-req">100 sesi ke atas</span>
                    </li>
                    <li class="tier-item">
                        <span class="tier-dot tier-dot-gold" aria-hidden="true"></span>
                        <span class="tier-name">Gold Member</span>
                        <span class="tier-req">50 sesi ke atas</span>
                    </li>
                    <li class="tier-item">
                        <span class="tier-dot tier-dot-silver" aria-hidden="true"></span>
                        <span class="tier-name">Silver Member</span>
                        <span class="tier-req">20 sesi ke atas</span>
                    </li>
                    <li class="tier-item">
                        <span class="tier-dot tier-dot-member" aria-hidden="true"></span>
                        <span class="tier-name">Member</span>
                        <span class="tier-req">Di bawah 20 sesi</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="gallery-section" id="gallery">
        <div class="section-header">
            <div>
                <span class="sub-label">GALERI ACTIVITY</span>
                <div class="section-title">
                    <h2>Keseruan Bermain</h2>
                </div>
            </div>
            <p class="section-desc">Momen keseruan para pemain di meja mahjong kami. Bergabunglah bersama kami!</p>
        </div>

        <div class="card-grid">
            <div class="grid-item">
                <div class="card-image-wrapper">
                    <img src="/assets/gallery/play1.jpg" alt="Pemain bermain mahjong santai bersama teman" class="item-image" width="900" height="1200" loading="lazy">
                </div>
                <div class="item-info">
                    <h3>Casual Match</h3>
                    <p>Bermain santai bersama teman-teman.</p>
                </div>
            </div>
            <div class="grid-item">
                <div class="card-image-wrapper">
                    <img src="/assets/gallery/play2.jpg" alt="Suasana turnamen mahjong mingguan" class="item-image" width="900" height="675" loading="lazy">
                </div>
                <div class="item-info">
                    <h3>Weekly Tournament</h3>
                    <p>Kompetisi mingguan penuh tantangan.</p>
                </div>
            </div>
            <div class="grid-item">
                <div class="card-image-wrapper">
                    <img src="/assets/gallery/about1.jpg" alt="Meja mahjong dengan suasana ruangan yang hangat" class="item-image" width="900" height="675" loading="lazy">
                </div>
                <div class="item-info">
                    <h3>Cozy Ambience</h3>
                    <p>Suasana tempat yang nyaman dan estetik.</p>
                </div>
            </div>
        </div>
    </section>
@endsection