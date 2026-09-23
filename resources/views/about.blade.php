@extends('layouts.public')

@section('title', 'About Us - FUN MAHJONG')

@section('content')
    <section class="about-hero">
        <div class="about-hero-container">
            <span class="sub-label">· OUR STORY</span>
            <h1 class="about-hero-title">Tentang Fun Mahjong</h1>
            <p class="about-hero-subtitle">Membawa kehangatan tradisi keluarga dari meja Lau Ma ke tengah komunitas Mahjong Pontianak.</p>
        </div>
    </section>

    <section class="about-content-section">
        <div class="about-container">

            <div class="story-block">
                <div class="story-image-wrapper">
                    <img src="/assets/gallery/about1.jpg" alt="Rumah Lau Ma" class="story-img" loading="lazy">
                    <div class="img-badge">FAMILY TRADITION</div>
                </div>
                <div class="story-text">
                    <div class="story-chapter">01</div>
                    <h2>Berawal dari Rumah Lau Ma</h2>
                    <p class="story-lead">
                        Bagi kami, Mahjong bukan cuma soal tiles atau permainan orang tua. Mahjong itu tentang momen kumpul-kumpul, tawa, dan rasa hangat di tengah keluarga.
                    </p>
                    <p>
                        Semua ini bermula dua tahun lalu di rumah Lau Ma (buyut kami) di Jakarta. Setiap hari Minggu, rumah selalu ramai karena empat generasi kumpul bareng, dari anak-anaknya (Tua Lau Kou, Sa Lau Kou, Soi Lau Kou), cucu, sampai para cicit.
                    </p>
                    <p>
                        Waktu itu Lau Ma sudah berumur 88 tahun, tapi semangatnya luar biasa. Dengan sabar, beliau ngajarin kami semua main Mahjong. Di meja itulah kami ngobrol, bercanda, dan makin dekat satu sama lain.
                    </p>
                </div>
            </div>

            <div class="story-quote-card">
                <div class="quote-icon">🀄</div>
                <blockquote>
                    "Di meja itulah kami ngobrol, bercanda, dan bener-bener lepas dari layar HP menikmati momen kebersamaan."
                </blockquote>
            </div>

            <div class="story-block reverse">
                <div class="story-image-wrapper">
                    <img src="/assets/gallery/play2.jpg" alt="Mahjong Pontianak" class="story-img" loading="lazy">
                    <div class="img-badge">PONTIANAK COMMUNITY</div>
                </div>
                <div class="story-text">
                    <div class="story-chapter">02</div>
                    <h2>Dari Jakarta Pindah ke Pontianak</h2>
                    <p>
                        Beberapa bulan lalu, waktu main lagi ke rumah Lau Ma di Jakarta, ternyata para A Kou (tante) masih rutin main. Dari situ saya mulai penasaran dan pengen nyoba belajar. Niat awal cuma mau nginep 3 hari di Jakarta, eh malah extend sampai seminggu gara-gara keasyikan main!
                    </p>
                    <p>
                        Pas pulang ke Pontianak, saya coba cari komunitas Mahjong (khususnya HK style), tapi ternyata belum ada. Akhirnya, bermodalkan ilmu dari Lau Ma dan para A Kou, saya coba ngajak temen-temen dekat buat main bareng.
                    </p>
                    <p>
                        Ternyata responsnya seru banget! Temen-temen ngerasa ini board game yang asyik banget. Dan yang paling penting: selama beberapa jam main, kami semua bisa bener-bener lepas dari layar HP dan menikmati momen ngobrol bareng tanpa kerasa waktu berlalu.
                    </p>
                    <div class="highlight-box">
                        <span>Dari situlah <strong>Fun Mahjong</strong> lahir.</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="about-cta-section">
        <div class="cta-card">
            <h2>Mari Bergabung di Meja Main Kami!</h2>
            <p>Ingin merasakan keseruan main Mahjong tanpa ribet? Cari teman main atau reservasi meja kamu sekarang di Fun Mahjong Pontianak.</p>
            <div class="cta-buttons">
                <a href="https://lynk.id/fun_mahjong" class="btn-hero-cta">Book a Table Now</a>
                <a href="{{ route('home') }}#gallery" class="btn-hero-secondary">Lihat Galeri Player</a>
            </div>
        </div>
    </section>
@endsection