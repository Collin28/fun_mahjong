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
                <label class="form-label-caps" for="phone">Nomor HP</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->username) }}" required minlength="10" maxlength="15" pattern="[0-9]{10,15}" autocomplete="tel" inputmode="numeric" class="form-control" @error('phone') aria-invalid="true" @enderror>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection