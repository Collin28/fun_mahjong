<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Fun Mahjong</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 240px;
            --orange-primary: #d95d1e;
            --orange-hover: #b84c14;
            --bg-light: #fbf9f6;
            --bg-card: #ffffff;
            --border-soft: #f1e3d3;
            --text-dark: #2b1d0c;
            --text-muted: #7d6e5d;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-light); color: var(--text-dark); display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background-color: #ffffff;
            border-right: 1px solid var(--border-soft);
            position: fixed;
            top: 0; bottom: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 24px 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-soft);
        }
        .sidebar-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--orange-primary);
            letter-spacing: 1px;
            line-height: 1.2;
        }
        .sidebar-brand p { font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; }
        
        .sidebar-menu { list-style: none; padding: 20px 12px; flex-grow: 1; }
        .sidebar-menu li { margin-bottom: 6px; }
        .sidebar-menu a {
            display: block;
            padding: 12px 16px;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .sidebar-menu a.active, .sidebar-menu a:hover {
            background-color: #fff4eb;
            color: var(--orange-primary);
        }

        .btn-logout {
            padding: 12px 16px;
            color: #d63031;
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #fab1a0;
            border-radius: 6px;
            margin: 20px 12px;
            background: #fff;
            cursor: pointer;
        }

        /* MAIN WRAPPER */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */
        .topbar {
            height: 65px;
            background: #fff;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-soft);
        }
        .topbar h3 { font-size: 1rem; font-weight: 700; color: var(--text-dark); }
        .user-profile { display: flex; align-items: center; gap: 10px; }
        .avatar-admin {
            width: 36px; height: 36px;
            background-color: #f1e3d3;
            color: var(--orange-primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
            border: 1px solid var(--orange-primary);
        }

        /* CONTENT AREA */
        .content { padding: 30px; }

        .page-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.6rem;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        /* NOTIFIKASI AUTO RESET */
        .info-box {
            background-color: #fff9f2;
            border: 1px dashed #e6aa68;
            padding: 14px 18px;
            border-radius: 8px;
            font-size: 0.88rem;
            color: #6b4311;
            margin-bottom: 25px;
        }

        /* GRID DUA FORM (POIN & MATCH) */
        .forms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card-box {
            background: var(--bg-card);
            border: 1px solid var(--border-soft);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }

        .card-box h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: var(--text-dark);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #4a3b2c;
        }

        .form-control {
            padding: 10px 14px;
            border: 1px solid #dcd0c0;
            border-radius: 6px;
            outline: none;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--orange-primary);
        }

        .btn-submit {
            background-color: var(--orange-primary);
            color: #fff;
            border: none;
            padding: 11px 18px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background-color: var(--orange-hover);
        }

        /* NAV TABS LEADERBOARD */
        .nav-tabs {
            display: flex;
            gap: 20px;
            border-bottom: 2px solid var(--border-soft);
            margin-bottom: 20px;
        }

        .nav-tab-item {
            padding: 10px 15px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.95rem;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .nav-tab-item.active {
            color: var(--orange-primary);
            border-bottom-color: var(--orange-primary);
        }

        /* TABLE LEADERBOARD */
        .table-leaderboard {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .table-leaderboard th {
            background-color: #fff8f0;
            padding: 12px;
            color: #5c4731;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--border-soft);
        }

        .table-leaderboard td {
            padding: 14px 12px;
            border-bottom: 1px solid #f5ede4;
            font-size: 0.9rem;
        }

        .user-profile-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #eee;
            object-fit: cover;
        }

        .badge-ultah {
            background-color: #ffe3e3;
            color: #d63031;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-left: 6px;
        }

        .btn-edit {
            background-color: var(--orange-primary);
            color: #fff;
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR LEFT -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1>FUN<br>MAHJONG</h1>
            <p>Admin Control Panel</p>
        </div>

        <ul class="sidebar-menu">
            <li><a href="#" class="active">Daftar Users</a></li>
            <li><a href="/admin/users/">Manage Users</a></li>
            <li><a href="#">Leaderboard</a></li>
            <li><a href="#">Pengaturan System</a></li>
        </ul>

        <form action="{{ route('logout') }}" method="POST">
            <button class="btn-logout">
            🚪 Logout
        </button>
        </form>
        
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        
        <!-- TOPBAR -->
        <header class="topbar">
            <h3>Dashboard Admin</h3>
            <div class="user-profile">
                <div class="avatar-admin">Adm</div>
                <span style="font-weight: 600; font-size: 0.9rem;">Administrator</span>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="content">
            <h2 class="page-title">Teknikal Leaderboard</h2>

            <!-- BANNER INFORMASI AUTO RESET -->
            <div class="info-box">
                <strong>Sistem Auto-Reset:</strong> Peringkat leaderboard otomatis diurutkan berdasarkan poin tertinggi. System mengecek rentang waktu dari <strong>03/09/2026</strong> hingga <strong>10/09/2026</strong> (7 Hari kedepan).
            </div>

            <!-- HALAMAN INPUT TERPISAH (POIN DAN MATCH) -->
            <div class="forms-grid">
                
                <!-- CARD 1: INPUT TAMBAH POIN -->
                <div class="card-box">
                    <h3>🏆 Tambah Poin (Kemenangan)</h3>
                    <form onsubmit="event.preventDefault();">
                        <div class="form-group">
                            <label>Pilih User</label>
                            <select class="form-control">
                                <option value="">budi_mahjong (Budi Santoso)</option>
                                <option value="">siti_pro (Siti Aminah)</option>
                                <option value="">ahmad_dragon (Ahmad)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tambah Point / Kemenangan</label>
                            <input type="number" class="form-control" placeholder="Contoh: 10">
                        </div>

                        <button type="submit" class="btn-submit">Tambah Point & Auto Sort</button>
                    </form>
                </div>

                <!-- CARD 2: INPUT TAMBAH MATCH -->
                <div class="card-box">
                    <h3>🀄 Tambah Match (Sering Main)</h3>
                    <form onsubmit="event.preventDefault();">
                        <div class="form-group">
                            <label>Pilih User</label>
                            <select class="form-control">
                                <option value="">budi_mahjong (Budi Santoso)</option>
                                <option value="">siti_pro (Siti Aminah)</option>
                                <option value="">ahmad_dragon (Ahmad)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tambah Total Permainan (Match)</label>
                            <input type="number" class="form-control" placeholder="Contoh: 1">
                        </div>

                        <button type="submit" class="btn-submit" style="background-color: #2c5e43;">Tambah Match (Top Loyal)</button>
                    </form>
                </div>

            </div>

            <!-- DATA LEADERBOARD & USER -->
            <h2 class="page-title">Data Leaderboard & User</h2>

            <div class="card-box">
                <!-- TABULASI PERINGKAT -->
                <div class="nav-tabs">
                    <a href="#" class="nav-tab-item active">Daily</a>
                    <a href="#" class="nav-tab-item">Weekly</a>
                    <a href="#" class="nav-tab-item">Top Player (Kemenangan)</a>
                    <a href="#" class="nav-tab-item">Top Loyal (Sering Main)</a>
                </div>

                <!-- TABEL USER STATIS -->
                <table class="table-leaderboard">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>User Profile</th>
                            <th>Username</th>
                            <th>TTL / Ultah</th>
                            <th>Total Kemenangan</th>
                            <th>Total Permainan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#1</strong></td>
                            <td>
                                <div class="user-profile-cell">
                                    <div class="avatar-img" style="background-image: url('https://via.placeholder.com/36'); background-size: cover;"></div>
                                    <span><strong>Budi Santoso</strong></span>
                                </div>
                            </td>
                            <td>budi_mahjong</td>
                            <td>12/10/1995</td>
                            <td><strong>145 Menang</strong></td>
                            <td>210 Main</td>
                            <td><a href="#" class="btn-edit">Edit</a></td>
                        </tr>
                        <tr>
                            <td><strong>#2</strong></td>
                            <td>
                                <div class="user-profile-cell">
                                    <div class="avatar-img" style="background-image: url('https://via.placeholder.com/36'); background-size: cover;"></div>
                                    <span><strong>Siti Aminah</strong></span>
                                </div>
                            </td>
                            <td>siti_pro</td>
                            <td>03/09/1998 <span class="badge-ultah">🎉 Hari Ini!</span></td>
                            <td><strong>120 Menang</strong></td>
                            <td>180 Main</td>
                            <td><a href="#" class="btn-edit">Edit</a></td>
                        </tr>
                        <tr>
                            <td><strong>#3</strong></td>
                            <td>
                                <div class="user-profile-cell">
                                    <div class="avatar-img" style="background-image: url('https://via.placeholder.com/36'); background-size: cover;"></div>
                                    <span><strong>Ahmad Raihan</strong></span>
                                </div>
                            </td>
                            <td>ahmad_dragon</td>
                            <td>20/01/2000</td>
                            <td><strong>98 Menang</strong></td>
                            <td>150 Main</td>
                            <td><a href="#" class="btn-edit">Edit</a></td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </main>
    </div>

</body>
</html>