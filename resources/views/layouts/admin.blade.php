<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Fun Mahjong')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --bg-cream: #FDF3E9;
            --bg-cream-dark: #F5E4D2;
            --accent-green: #15382B;
            --accent-green-dark: #0D241B;
            --accent-green-light: #1E4D3B;
            --primary-orange: #E85D04;
            --primary-orange-hover: #DC2F02;
            --accent-red: #D00000;
            --accent-silver: #E2E8F0;
            --accent-gold: #FFB703;
            --text-dark: #1B2820;
            --text-muted: #5A655D;
            --white: #FFFFFF;
            --font-heading: 'Playfair Display', serif;
            --font-sans: 'Plus Jakarta Sans', sans-serif;

            /* Focus rings: deep green on light surfaces, gold on the dark sidebar. */
            --focus-ring: #15382B;
            --focus-ring-light: #FFB703;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-sans);
        }

        /* ACCESSIBILITY FOUNDATIONS */
        :focus-visible {
            outline: 3px solid var(--focus-ring);
            outline-offset: 2px;
            border-radius: 4px;
        }

        .sidebar :focus-visible {
            outline-color: var(--focus-ring-light);
        }

        .content:focus {
            outline: none;
        }

        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .skip-link {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 2000;
            transform: translateY(-120%);
            background-color: var(--accent-green);
            color: var(--white);
            padding: 12px 20px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            border-radius: 0 0 10px 0;
        }

        .skip-link:focus {
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        body {
            background-color: var(--bg-cream);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--accent-green);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            border-right: 3px solid var(--primary-orange);
        }

        .sidebar-brand {
            padding: 28px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-brand-name {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            color: var(--white);
            letter-spacing: 1px;
            line-height: 1.2;
            font-weight: 700;
        }

        .sidebar-brand-role {
            font-size: 0.72rem;
            color: var(--accent-gold);
            margin-top: 6px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .sidebar-menu {
            list-style: none;
            padding: 24px 16px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-menu li {
            margin-bottom: 6px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            min-height: 44px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: var(--white);
        }

        .sidebar-menu a.active {
            background-color: var(--primary-orange);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(232, 93, 4, 0.35);
        }

        .sidebar-menu a .menu-icon {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        .btn-logout {
            padding: 12px 18px;
            min-height: 44px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            margin: 16px;
            background: transparent;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s;
            width: calc(100% - 32px);
        }

        .btn-logout:hover {
            background-color: var(--accent-red);
            border-color: var(--accent-red);
            color: var(--white);
        }

        /* MAIN WRAPPER */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            height: 68px;
            background: var(--white);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid rgba(21, 56, 43, 0.08);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-profile-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .avatar-admin {
            width: 38px;
            height: 38px;
            background-color: var(--accent-green-light);
            color: var(--accent-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* CONTENT AREA */
        .content {
            padding: 32px;
            flex: 1;
        }

        .page-title {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--accent-green);
            margin-bottom: 20px;
        }

        /* NOTIFIKASI */
        .alert-success {
            background-color: #eaf7ef;
            border: 1px solid var(--accent-green-light);
            color: var(--accent-green-dark);
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-error {
            background-color: #fdecec;
            border: 1px solid var(--accent-red);
            color: #8f1d1d;
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* CARD BOX */
        .card-box {
            background: var(--white);
            border: 1px solid rgba(21, 56, 43, 0.08);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(21, 56, 43, 0.04);
        }

        .card-box h3 {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            margin-bottom: 16px;
            color: var(--accent-green);
        }

        .card-box-flush {
            padding: 0;
            overflow: hidden;
        }

        .card-box-header {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(21, 56, 43, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .card-box-label {
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .count-pill {
            background-color: rgba(255, 183, 3, 0.15);
            color: #7A5800;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .col-center {
            text-align: center;
        }

        .cell-muted {
            color: var(--text-muted);
        }

        .user-cell-name {
            display: block;
            font-weight: 700;
            color: var(--text-dark);
        }

        .user-cell-handle {
            display: block;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .row-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .inline-form {
            display: inline;
        }

        /* INFO BOX */
        .info-box {
            background-color: rgba(255, 183, 3, 0.08);
            border: 1px dashed #B07E00;
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 0.88rem;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .reset-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .reset-bar .info-box {
            flex: 1 1 320px;
        }

        .btn-reset {
            width: auto;
            white-space: nowrap;
            min-height: 44px;
        }

        /* FORM ELEMENTS */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        .form-label-caps {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
        }

        .form-label-note {
            text-transform: none;
            font-weight: 400;
            color: var(--text-muted);
            letter-spacing: 0;
        }

        .form-hint {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .stacked-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-actions {
            padding-top: 8px;
        }

        .alert-title {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .alert-list {
            margin: 0;
            padding-left: 20px;
        }

        .form-control[aria-invalid="true"] {
            border-color: var(--accent-red);
            background-color: #FFF8F8;
        }

        .form-control {
            padding: 12px 16px;
            border: 1px solid rgba(21, 56, 43, 0.15);
            border-radius: 10px;
            font-size: 1rem;
            font-family: var(--font-sans);
            background: var(--white);
            min-height: 44px;
            transition: border-color 0.2s;
        }

        /* Keep the global :focus-visible ring; only add the border tint. */
        .form-control:focus-visible {
            border-color: var(--accent-green);
        }

        .btn-submit {
            background-color: var(--primary-orange);
            color: var(--white);
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
            font-family: var(--font-sans);
            font-size: 0.9rem;
        }

        .btn-submit:hover {
            background-color: var(--primary-orange-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(232, 93, 4, 0.3);
        }

        .btn-submit-danger {
            background-color: var(--accent-red);
        }

        .btn-submit-danger:hover {
            background-color: #a30000;
        }

        .btn-link {
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .btn-link:hover {
            color: var(--primary-orange-hover);
        }

        /* NAV TABS */
        .nav-tabs {
            display: flex;
            gap: 6px;
            border-bottom: 2px solid rgba(21, 56, 43, 0.08);
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .nav-tab-item {
            padding: 10px 20px;
            min-height: 44px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            font-family: var(--font-sans);
            border: none;
            border-radius: 8px 8px 0 0;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s;
            background: none;
            cursor: pointer;
        }

        .nav-tab-item:hover {
            color: var(--primary-orange);
        }

        .nav-tab-item.active {
            color: var(--primary-orange);
            border-bottom-color: var(--primary-orange);
        }

        /* TAB PANEL */
        .tab-panel,
        .tab-panel[hidden] {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .page-title-flush {
            margin-bottom: 0;
        }

        /* INLINE FEEDBACK FOR STEPPER ACTIONS */
        .stat-feedback {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 200;
            max-width: 340px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(21, 56, 43, 0.18);
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .stat-feedback[hidden] {
            display: none;
        }

        .stat-feedback-error {
            background-color: #FDECEC;
            border: 1px solid var(--accent-red);
            color: #8F1D1D;
        }

        .stat-feedback-success {
            background-color: #EAF7EF;
            border: 1px solid var(--accent-green-light);
            color: var(--accent-green-dark);
        }

        .step-counter.is-busy {
            opacity: 0.5;
        }

        .step-counter.is-updated {
            animation: countPulse 0.4s ease;
        }

        @keyframes countPulse {
            0%   { background-color: rgba(255, 183, 3, 0.55); }
            100% { background-color: var(--bg-cream); }
        }

        /* TABLE */
        .table-leaderboard {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .table-leaderboard th {
            background-color: var(--accent-green);
            color: var(--white);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 14px 16px;
            border-bottom: none;
        }

        .table-leaderboard td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(21, 56, 43, 0.06);
            font-size: 0.9rem;
        }

        .table-leaderboard tr:last-child td {
            border-bottom: none;
        }

        .table-leaderboard tr:hover td {
            background-color: var(--bg-cream);
        }

        /* USER PROFILE CELL */
        .user-profile-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-img {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 50%;
            background-color: var(--accent-green-light);
            color: var(--accent-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .avatar-lg {
            width: 72px;
            height: 72px;
            font-size: 1.5rem;
        }

        /* USER DETAIL */
        .card-box-narrow {
            max-width: 720px;
            padding: 32px;
        }

        .detail-identity {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid rgba(21, 56, 43, 0.08);
            padding-bottom: 24px;
        }

        .detail-name {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--text-dark);
        }

        .detail-handle {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            padding-top: 24px;
            font-size: 0.95rem;
        }

        .detail-field dt {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .detail-field dd {
            font-weight: 600;
            color: var(--text-dark);
            margin-top: 4px;
        }

        .detail-value-accent {
            color: var(--primary-orange);
        }

        .detail-value-green {
            color: var(--accent-green);
        }

        .badge-ultah {
            background-color: #FFE3E3;
            color: #A30000;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .table-empty {
            text-align: center;
            padding: 32px 20px;
        }

        .empty-title {
            display: block;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .empty-hint {
            display: block;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* STEPPER */
        .stepper {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .step-btn {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            color: var(--white);
        }

        .step-plus {
            background-color: var(--accent-green-light);
        }

        .step-plus:hover {
            background-color: var(--accent-green);
        }

        .step-minus {
            background-color: var(--primary-orange);
        }

        .step-minus:hover:not(.step-disabled) {
            background-color: var(--primary-orange-hover);
        }

        .step-disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .step-btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .step-counter {
            min-width: 40px;
            text-align: center;
            font-weight: 700;
            font-size: 0.95rem;
            background: var(--bg-cream);
            border: 1px solid rgba(21, 56, 43, 0.1);
            border-radius: 8px;
            padding: 6px 10px;
        }

        /* BTN EDIT */
        .btn-edit {
            background-color: var(--primary-orange);
            color: var(--white);
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-block;
            min-height: 40px;
        }

        .btn-edit:hover {
            background-color: var(--primary-orange-hover);
            transform: translateY(-1px);
        }

        /* ACTION BUTTONS */
        .btn-action {
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-block;
            border: none;
            cursor: pointer;
            min-height: 40px;
        }

        .btn-action-detail {
            background-color: rgba(21, 56, 43, 0.08);
            color: var(--accent-green);
        }

        .btn-action-detail:hover {
            background-color: var(--accent-green);
            color: var(--white);
        }

        .btn-action-edit {
            background-color: rgba(232, 93, 4, 0.1);
            color: var(--primary-orange);
        }

        .btn-action-edit:hover {
            background-color: var(--primary-orange);
            color: var(--white);
        }

        .btn-action-delete {
            background-color: rgba(208, 0, 0, 0.08);
            color: var(--accent-red);
            border: none;
        }

        .btn-action-delete:hover {
            background-color: var(--accent-red);
            color: var(--white);
        }

        /* TOPBAR MENU BUTTON (MOBILE) */
        .topbar-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px 8px;
            border-radius: 8px;
            margin-right: 10px;
        }

        .topbar-menu-btn .bar {
            display: block;
            width: 22px;
            height: 3px;
            background-color: var(--accent-green);
            margin: 5px 0;
            border-radius: 3px;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        body.admin-menu-open .topbar-menu-btn .bar:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        body.admin-menu-open .topbar-menu-btn .bar:nth-child(2) {
            opacity: 0;
        }

        body.admin-menu-open .topbar-menu-btn .bar:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        .topbar-heading {
            display: flex;
            align-items: center;
            min-width: 0;
        }

        /* SIDEBAR BACKDROP (MOBILE) */
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background-color: rgba(13, 36, 27, 0.5);
            z-index: 95;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
            display: none;
        }

        /* TABLE RESPONSIVE */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }
            :root {
                --sidebar-width: 220px;
            }
        }

        @media (max-width: 768px) {
            .topbar-menu-btn {
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
                width: 260px;
            }

            body.admin-menu-open .sidebar {
                transform: translateX(0);
                box-shadow: 0 0 40px rgba(0, 0, 0, 0.35);
            }

            .sidebar-backdrop {
                display: block;
            }

            body.admin-menu-open .sidebar-backdrop {
                opacity: 1;
                pointer-events: auto;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .content {
                padding: 20px 16px 32px;
            }

            .topbar {
                padding: 0 16px;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .user-profile-name {
                display: none;
            }

            .topbar-title {
                font-size: 0.9rem;
            }

            .card-box {
                padding: 16px;
            }
        }
    </style>
    @yield('head')
</head>

<body>

    <a href="#main-content" class="skip-link">Lompat ke konten utama</a>

    <!-- SIDEBAR BACKDROP -->
    <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar" aria-label="Navigasi admin">
        <div class="sidebar-brand">
            <p class="sidebar-brand-name">FUN<br>MAHJONG</p>
            <p class="sidebar-brand-role">Admin Panel</p>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                    <span class="menu-icon" aria-hidden="true">&#x1F3C6;</span> Leaderboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" @if(request()->routeIs('admin.users.*')) aria-current="page" @endif>
                    <span class="menu-icon" aria-hidden="true">&#x1F465;</span> Manage Users
                </a>
            </li>
        </ul>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <span class="menu-icon" aria-hidden="true">&#x1F6AA;</span> Logout
            </button>
        </form>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-heading">
                <button type="button" class="topbar-menu-btn" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="sidebar">
                    <span class="bar" aria-hidden="true"></span>
                    <span class="bar" aria-hidden="true"></span>
                    <span class="bar" aria-hidden="true"></span>
                </button>
                <p class="topbar-title">@yield('topbar-title', 'Dashboard Admin')</p>
            </div>
            <div class="user-profile">
                <span class="avatar-admin" aria-hidden="true">Adm</span>
                <span class="user-profile-name">{{ auth()->user()->name ?? 'Administrator' }}</span>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="content" id="main-content" tabindex="-1">
            @yield('content')
        </main>
    </div>

    <script>
        (function () {
            var btn = document.querySelector('.topbar-menu-btn');
            var backdrop = document.getElementById('sidebar-backdrop');
            var sidebar = document.getElementById('sidebar');
            if (!btn || !sidebar) return;

            var mobileQuery = window.matchMedia('(max-width: 768px)');

            function setOpen(open) {
                document.body.classList.toggle('admin-menu-open', open);
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');

                // Off-canvas sidebar stays out of the tab order while hidden.
                if (mobileQuery.matches && !open) {
                    sidebar.setAttribute('inert', '');
                } else {
                    sidebar.removeAttribute('inert');
                }
            }

            function closeMenu(returnFocus) {
                if (!document.body.classList.contains('admin-menu-open')) return;
                setOpen(false);
                if (returnFocus) btn.focus();
            }

            btn.addEventListener('click', function () {
                setOpen(!document.body.classList.contains('admin-menu-open'));
            });

            if (backdrop) {
                backdrop.addEventListener('click', function () { closeMenu(false); });
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeMenu(true);
            });

            sidebar.addEventListener('click', function (e) {
                if (e.target.closest('a, button')) closeMenu(false);
            });

            function syncToViewport() {
                setOpen(false);
            }

            if (mobileQuery.addEventListener) {
                mobileQuery.addEventListener('change', syncToViewport);
            } else if (mobileQuery.addListener) {
                mobileQuery.addListener(syncToViewport);
            }

            syncToViewport();
        })();
    </script>

    @yield('scripts')
</body>

</html>
