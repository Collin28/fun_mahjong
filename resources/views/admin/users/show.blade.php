@extends('layouts.admin')

@section('title', 'Fun Mahjong - Detail User')
@section('topbar-title', 'Dashboard Admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title page-title-flush">Detail User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn-link"><span aria-hidden="true">&#x2190;</span> Kembali ke daftar user</a>
    </div>

    <div class="card-box card-box-narrow">
        <div class="detail-identity">
            <span class="avatar-img avatar-lg" aria-hidden="true">{{ $user->profile_animal_emoji }}</span>
            <div>
                <h2 class="detail-name">{{ $user->name }}</h2>
                <p class="detail-handle">{{ '@' . $user->username }}</p>
            </div>
        </div>

        <dl class="detail-grid">
            <div class="detail-field">
                <dt>Email</dt>
                <dd>{{ $user->email }}</dd>
            </div>
            <div class="detail-field">
                <dt>Tanggal Lahir</dt>
                <dd>{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d F') : '-' }}</dd>
            </div>
            <div class="detail-field">
                <dt>Total Kemenangan (Poin)</dt>
                <dd class="detail-value-accent">{{ $user->total_wins ?? 0 }} Win</dd>
            </div>
            <div class="detail-field">
                <dt>Total Permainan (Match)</dt>
                <dd class="detail-value-green">{{ $user->total_played ?? 0 }} Match</dd>
            </div>
        </dl>
    </div>
@endsection
