@extends('layouts.admin')

@section('title', 'Fun Mahjong - Manage Users')
@section('topbar-title', 'Dashboard Admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title page-title-flush">Manage Users</h1>
    </div>

    @if(session('success'))
        <div class="alert-success" role="status">
            <span aria-hidden="true">&#x2705;</span> {{ session('success') }}
        </div>
    @endif

    <div class="card-box card-box-flush">
        <div class="card-box-header">
            <span class="card-box-label">Daftar Pengguna Terdaftar</span>
            <span class="count-pill">{{ $users->count() }} Users</span>
        </div>

        <div class="table-responsive" tabindex="0" role="region" aria-label="Daftar pengguna terdaftar">
            <table class="table-leaderboard">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col" class="col-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-profile-cell">
                                    <span class="avatar-img" aria-hidden="true">{{ $user->profile_animal_emoji }}</span>
                                    <span>
                                        <span class="user-cell-name">{{ $user->name }}</span>
                                        <span class="user-cell-handle">{{ '@' . $user->username }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="cell-muted">{{ $user->email }}</td>
                            <td class="cell-muted">{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d M') : '-' }}</td>
                            <td class="col-center">
                                <div class="row-actions">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn-action btn-action-detail">
                                        Detail<span class="visually-hidden"> {{ $user->name }}</span>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action btn-action-edit">
                                        Edit<span class="visually-hidden"> {{ $user->name }}</span>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus user {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.');"
                                        class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-action-delete">
                                            Hapus<span class="visually-hidden"> {{ $user->name }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table-empty">
                                <span class="empty-title">Belum ada data user</span>
                                <span class="empty-hint">User yang mendaftar lewat halaman registrasi akan muncul di sini.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
