<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FUN MAHJONG</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <header class="header">
        <nav class="navbar">
            <ul class="nav-left">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="index.php#leaderboard">Papan Peringkat</a></li>
                <li><a href="index.php#rules">Aturan</a></li>
                <li><a href="about-us.php">Tentang Kami</a></li>
            </ul>

            <div class="nav-brand">
                <a href="index.php" class="logo">
                    <img src="/images/mahjong.jpeg" alt="FUN MAHJONG" class="logo-img">
                </a>
            </div>

            <div class="nav-right">
                <a href="login.php" class="nav-link">Masuk</a>
                <a href="https://lynk.id/fun_mahjong" class="btn-book">Pesan Permainan</a>
            </div>
        </nav>
    </header>

    <section class="hero login-container">
        <div class="login-card">
            <h2 class="login-title">Buat Akun Baru</h2>
            @if($errors->any())
                <div style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <p class="login-subtitle">Bergabunglah dengan komunitas Fun Mahjong!</p>

            <form action="{{ route('register') }}" method="POST" class="login-form">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required class="form-input" placeholder="Masukkan nama lengkap">
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required class="form-input" placeholder="Pilih username">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required class="form-input" placeholder="nama@email.com">
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="birth_date" required class="form-input">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required class="form-input" placeholder="Minimal 6 karakter">
                </div>

                <!-- <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confimation" required class="form-input" placeholder="Konfirmasi Password Anda">
                </div> -->

                <button type="submit" class="btn-book btn-login-submit">Daftar Sekarang</button>
            </form>

            <p style="text-align: center; margin-top: 18px; font-size: 0.85rem; color: var(--text-muted);">
                Sudah punya akun? <a href="/login"
                    style="color: var(--primary-orange); font-weight: 700; text-decoration: none;">Masuk di sini</a>
            </p>
        </div>
    </section>

</body>

</html>