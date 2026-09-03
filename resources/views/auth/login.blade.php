<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - FUN MAHJONG</title>
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
                    <img src="/assets/logo.png" alt="FUN MAHJONG" class="logo-img">
                </a>
            </div>

            <div class="nav-right">
                <a href="login.php" class="nav-link active">Masuk</a>
                <a href="https://lynk.id/fun_mahjong" class="btn-book">Pesan Permainan</a>
            </div>
        </nav>
    </header>

    <section class="hero login-container">
        <div class="login-card">
            <h2 class="login-title">Selamat Datang</h2>
            <p class="login-subtitle">Silakan masuk ke akun Fun Mahjong kamu.</p>

            <form action="" method="POST" class="login-form">
                <div class="form-group">
                    <label>Username / Email</label>
                    <input type="text" name="username" required class="form-input">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required class="form-input">
                </div>

                <button type="submit" class="btn-book btn-login-submit">Masuk</button>
            </form>

            <p style="text-align: center; margin-top: 18px; font-size: 0.85rem; color: var(--text-muted);">
                Belum punya akun? <a href="register.php"
                    style="color: var(--primary-orange); font-weight: 700; text-decoration: none;">Daftar di sini</a>
            </p>
        </div>
    </section>

</body>

</html>