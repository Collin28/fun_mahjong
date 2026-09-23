@extends('layouts.admin')

@section('title', 'Fun Mahjong - Edit User')
@section('topbar-title', 'Dashboard Admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title page-title-flush">Edit User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn-link"><span aria-hidden="true">&#x2190;</span> Batal</a>
    </div>

    @if ($errors->any())
        <div class="alert-error" role="alert">
            <div>
                <p class="alert-title">Perubahan belum tersimpan</p>
                <ul class="alert-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card-box card-box-narrow">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="stacked-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label-caps" for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name" class="form-control" @error('name') aria-invalid="true" @enderror>
            </div>

            <div class="form-group">
                <label class="form-label-caps" for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required maxlength="255" autocomplete="username" autocapitalize="none" spellcheck="false" class="form-control" @error('username') aria-invalid="true" @enderror>
            </div>

            <div class="form-group">
                <label class="form-label-caps" for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required maxlength="255" autocomplete="email" autocapitalize="none" spellcheck="false" class="form-control" @error('email') aria-invalid="true" @enderror>
            </div>

            <div class="form-group">
                <label class="form-label-caps" for="birth_date">Tanggal Lahir</label>
                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $user->birth_date) }}" required max="{{ date('Y-m-d') }}" class="form-control" @error('birth_date') aria-invalid="true" @enderror>
            </div>

            <div class="form-group">
                <label class="form-label-caps" for="password">
                    Password Baru <span class="form-label-note">(Kosongkan jika tidak diubah)</span>
                </label>
                <input type="password" name="password" id="password" minlength="6" autocomplete="new-password" class="form-control" aria-describedby="password-hint" @error('password') aria-invalid="true" @enderror>
                <p class="form-hint" id="password-hint">Minimal 6 karakter. Biarkan kosong untuk mempertahankan password lama.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection