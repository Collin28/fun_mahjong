<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fun Mahjong</title>
    <style>
        /* --- SYSTEM & COLOR VARIABLES --- */
        :root {
            --bg-main: #fdf8ef;
            --bg-card: #ffffff;
            --primary: #d06328;
            --primary-hover: #b8521d;
            --text-dark: #2c2523;
            --text-muted: #7d7571;
            --border-color: #ebdccb;
            --accent-badge: #fff3e6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR STYLE --- */
        .sidebar {
            width: 250px;
            background-color: var(--bg-card);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 24px 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-header h2 {
            font-family: 'Georgia', serif;
            color: var(--primary);
            letter-spacing: 1px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li a {
            display: block;
            padding: 12px 24px;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: var(--accent-badge);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }

        /* --- MAIN CONTENT AREA --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Header Topbar */
        .topbar {
            background-color: var(--bg-card);
            padding: 16px 32px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .container {
            padding: 32px;
            max-width: 1200px;
        }

        .section-title {
            font-family: 'Georgia', serif;
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        /* --- CARDS & GRID --- */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        /* --- FORM CONTROLS --- */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-control {
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background-color: #fafafa;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            background-color: #fff;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        /* --- TAB NAVIGATION --- */
        .tabs {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 20px;
        }

        .tab-item {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .tab-item.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        /* --- TABLES --- */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: var(--accent-badge);
            color: var(--text-dark);
            font-size: 14px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .badge-birthday {
            background-color: #ffe6e6;
            color: #d93838;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .info-banner {
            background-color: var(--accent-badge);
            border: 1px dashed var(--primary);
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>FUN MAHJONG</h2>
            <small style="color: var(--text-muted);">Admin Control Panel</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class="active">Daftar Users</a></li>
            <li><a href="#">Leaderboard</a></li>
            <li><a href="#">Hadiah Ulang Tahun</a></li>
            <li><a href="#">Pengaturan System</a></li>

            <form action="{{ route('logout') }}" method="POST">
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition duration-150 ease-in-out shadow-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </ul>
    </aside>

    <main class="main-content">

        <header class="topbar">
            <div><strong>Dashboard Admin</strong></div>
            <div class="user-profile">
                <img src="https://via.placeholder.com/40" alt="Admin Avatar" class="avatar">
                <span>Administrator</span>
            </div>
        </header>

        <div class="container">

            <h2 class="section-title">Teknikal Leaderboard</h2>
            <div class="card">
                <div class="info-banner">
                    <strong>Sistem Auto-Reset:</strong> Peringkat leaderboard otomatis diurutkan berdasarkan poin
                    tertinggi. System mengecek rentang waktu dari <strong>03/09/2026</strong> hingga
                    <strong>10/09/2026</strong> (7 Hari kedepan).
                </div>

                <form class="form-grid">
                    <div class="form-group">
                        <label for="select-user">Pilih User</label>
                        <select id="select-user" class="form-control">
                            <option value="">-- Pilih Username --</option>
                            <option value="user1">budi_mahjong (Budi Santoso)</option>
                            <option value="user2">siti_pro (Siti Aminah)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-point">Tambah Point / Kemenangan</label>
                        <input type="number" id="input-point" class="form-control" placeholder="Contoh: 10">
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-primary">Tambah Point & Auto Sort</button>
                    </div>
                </form>
            </div>

            <h2 class="section-title">Data Leaderboard & User</h2>
            <div class="card">

                <div class="tabs">
                    <div class="tab-item active">Daily</div>
                    <div class="tab-item">Weekly</div>
                    <div class="tab-item">Top Player (Kemenangan)</div>
                    <div class="tab-item">Top Loyal (Sering Main)</div>
                </div>

                <div class="table-responsive">
                    <table>
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
                                    <div class="user-info">
                                        <img src="https://via.placeholder.com/40" alt="Profile" class="avatar">
                                        <span>Budi Santoso</span>
                                    </div>
                                </td>
                                <td>budi_mahjong</td>
                                <td>12/10/1995</td>
                                <td><strong>145 Menang</strong></td>
                                <td>210 Main</td>
                                <td><button class="btn btn-primary"
                                        style="padding: 6px 12px; font-size: 12px;">Edit</button></td>
                            </tr>
                            <tr>
                                <td><strong>#2</strong></td>
                                <td>
                                    <div class="user-info">
                                        <img src="https://via.placeholder.com/40" alt="Profile" class="avatar">
                                        <span>Siti Aminah</span>
                                    </div>
                                </td>
                                <td>siti_pro</td>
                                <td>03/09/1998 <span class="badge-birthday">🎉 Hari Ini!</span></td>
                                <td><strong>120 Menang</strong></td>
                                <td>180 Main</td>
                                <td><button class="btn btn-primary"
                                        style="padding: 6px 12px; font-size: 12px;">Edit</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </main>

</body>

</html>