@extends('layouts.public')

@section('title', 'Dashboard - FUN MAHJONG')
@section('meta-description', 'Lihat statistik permainan mahjong kamu: total kemenangan, jumlah match, dan posisi di papan peringkat.')

@section('content')
    <section class="about-hero">
        <div class="about-hero-container">
            <span class="sub-label">MEMBER DASHBOARD</span>
            <h1 class="about-hero-title"><span role="img" aria-label="Profil {{ $user->profile_animal_label }}">{{ $user->profile_animal_emoji }}</span> Halo, {{ $user->name }}</h1>
            <p class="about-hero-subtitle">Selamat datang kembali di Fun Mahjong. Ini progres permainan kamu.</p>
        </div>
    </section>

    <section class="stats-section">
        <h2 class="visually-hidden">Ringkasan statistik kamu</h2>

        <div class="stat-grid">
            <div class="stat-card">
                <p class="stat-label">Total Kemenangan</p>
                <p class="stat-value">{{ number_format($user->total_wins ?? 0) }}</p>
            </div>

            <div class="stat-card">
                <p class="stat-label">Total Match</p>
                <p class="stat-value">{{ number_format($user->total_played ?? 0) }}</p>
            </div>

            <div class="stat-card">
                <p class="stat-label">Kemenangan Minggu Ini</p>
                <p class="stat-value">{{ number_format($user->weekly_wins ?? 0) }}</p>
            </div>

            <div class="stat-card stat-card-highlight">
                <p class="stat-label">Peringkat</p>
                <p class="stat-value stat-value-accent">#{{ $allTimeRank }}</p>
                <p class="stat-caption">Top Players sepanjang waktu</p>
            </div>
        </div>

        @if(($user->total_played ?? 0) === 0)
            <p class="stats-empty-note">
                Belum ada sesi yang tercatat. Statistik kamu akan terisi setelah pengelola mencatat permainan pertama kamu.
            </p>
        @endif
    </section>

    @include('partials.leaderboard-section', [
        'dailyUsers' => $dailyUsers,
        'weeklyUsers' => $weeklyUsers,
        'topPlayers' => $topPlayers,
        'topLoyal' => $topLoyal,
    ])
@endsection
