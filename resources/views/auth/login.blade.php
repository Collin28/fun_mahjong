@extends('layouts.public')

@section('title', 'Login Admin - FUN MAHJONG')
@section('meta-description', 'Halaman login khusus administrator Fun Mahjong.')

@section('content')
    <section class="hero login-container">
        <div class="login-card">
            <h1 class="login-title">Login Admin</h1>
            <p class="login-subtitle">Halaman ini hanya untuk admin. Pemain tidak perlu login.</p>

            @if(session('success'))
                <div class="form-alert form-alert-success" role="status">
                    <span class="form-alert-icon" aria-hidden="true">✓</span>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="form-alert form-alert-error" role="alert">
                    <span class="form-alert-icon" aria-hidden="true">!</span>
                    <div>
                        <p class="form-alert-title">Gagal masuk</p>
                        <ul class="form-alert-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        value="{{ old('username') }}"
                        required
                        autocomplete="username"
                        autocapitalize="none"
                        spellcheck="false"
                        class="form-input"
                        @error('username') aria-invalid="true" @enderror
                        placeholder="Masukkan username">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        autocomplete="current-password"
                        class="form-input"
                        @error('password') aria-invalid="true" @enderror
                        placeholder="Masukkan password">
                </div>

                <button type="submit" class="btn-book btn-login-submit">Masuk</button>
            </form>

            <p class="login-alt-action">
                Ingin mendaftarkan data pemain? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
        </div>
    </section>
@endsection
