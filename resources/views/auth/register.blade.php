@extends('layouts.public')

@section('title', 'Daftar - FUN MAHJONG')
@section('meta-description', 'Daftarkan nama dan nomor HP untuk pendataan pemain Fun Mahjong. Tidak perlu membuat akun atau login.')

@section('content')
    <section class="hero login-container">
        <div class="login-card">
            <h1 class="login-title">Pendaftaran Pemain</h1>
            <p class="login-subtitle">Cukup isi nama dan nomor HP. Tidak perlu login.</p>

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
                    <label for="name">Nama</label>
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
                        placeholder="Masukkan nama">
                </div>

                <div class="form-group">
                    <label for="phone">Nomor HP</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                        required minlength="10" maxlength="15" pattern="[0-9]{10,15}"
                        autocomplete="tel" inputmode="numeric" class="form-input"
                        @error('phone') aria-invalid="true" @enderror
                        placeholder="Contoh: 081234567890">
                    <p class="form-hint">Masukkan 10–15 digit angka tanpa spasi atau tanda +.</p>
                </div>

                <button type="submit" class="btn-book btn-login-submit">Daftar Sekarang</button>
            </form>

            @if(session('success'))
                <div class="form-alert form-alert-success" role="status">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
        </div>
    </section>
@endsection
