@extends('layouts.public')

@section('title', 'Daftar - FUN MAHJONG')
@section('meta-description', 'Buat akun Fun Mahjong untuk mencatat statistik permainan kamu dan masuk ke papan peringkat komunitas.')

@section('content')
    <section class="hero login-container">
        <div class="login-card">
            <h1 class="login-title">Buat Akun Baru</h1>
            <p class="login-subtitle">Bergabunglah dengan komunitas Fun Mahjong.</p>

            @if($errors->any())
                <div class="form-alert form-alert-error" role="alert">
                    <span class="form-alert-icon" aria-hidden="true">!</span>
                    <div>
                        <p class="form-alert-title">Pendaftaran belum berhasil</p>
                        <ul class="form-alert-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        maxlength="255"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        class="form-input"
                        @error('name') aria-invalid="true" @enderror
                        placeholder="Masukkan nama lengkap">
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        maxlength="255"
                        value="{{ old('username') }}"
                        required
                        autocomplete="username"
                        autocapitalize="none"
                        spellcheck="false"
                        class="form-input"
                        @error('username') aria-invalid="true" @enderror
                        placeholder="Pilih username">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        maxlength="255"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autocapitalize="none"
                        spellcheck="false"
                        class="form-input"
                        @error('email') aria-invalid="true" @enderror
                        placeholder="nama@email.com">
                </div>

                <div class="form-group">
                    <label id="birth-label">Bulan dan Hari Lahir</label>
                    <div class="form-row-birth">
                        <div class="form-col-birth">
                            <select
                                name="birth_month"
                                id="birth_month"
                                class="form-input"
                                required
                                autocomplete="bday-month"
                                aria-label="Bulan lahir"
                                @error('birth_month') aria-invalid="true" @enderror>
                                <option value="" disabled {{ old('birth_month') ? '' : 'selected' }}>Bulan</option>
                                @foreach([
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                                ] as $monthNumber => $monthName)
                                    <option value="{{ $monthNumber }}" @selected(old('birth_month') == $monthNumber)>{{ $monthName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-col-birth">
                            <select
                                name="birth_day"
                                id="birth_day"
                                class="form-input"
                                required
                                autocomplete="bday-day"
                                aria-label="Hari lahir"
                                @error('birth_day') aria-invalid="true" @enderror>
                                <option value="" disabled {{ old('birth_day') ? '' : 'selected' }}>Hari</option>
                                @for($day = 1; $day <= 31; $day++)
                                    <option value="{{ $day }}" @selected(old('birth_day') == $day)>{{ $day }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        minlength="6"
                        autocomplete="new-password"
                        class="form-input"
                        aria-describedby="password-hint"
                        @error('password') aria-invalid="true" @enderror
                        placeholder="Minimal 6 karakter">
                    <p class="form-hint" id="password-hint">Gunakan minimal 6 karakter.</p>
                </div>

                <button type="submit" class="btn-book btn-login-submit">Daftar Sekarang</button>
            </form>

            <p class="login-alt-action">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
        </div>
    </section>
@endsection
