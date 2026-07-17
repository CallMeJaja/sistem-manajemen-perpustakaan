@extends('layouts.auth')

@section('title', 'Daftar Anggota — GramediKu')
@section('logo', 'person-plus')
@section('card-title', 'Daftar Anggota')
@section('card-subtitle', 'Buat akun untuk reservasi buku secara online')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <x-form-field name="name" label="Nama Lengkap" required autofocus />
    <x-form-field name="email" label="Email" type="email" required />
    <x-form-field name="phone" label="No. Telepon" type="tel" required placeholder="08xxxxxxxxxx" />
    <x-form-field name="password" label="Kata Sandi" type="password" required placeholder="Minimal 8 karakter" />
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-person-check me-2"></i>Daftar
    </button>
</form>

<div class="text-center mt-4 small">
    <span class="text-muted">Sudah punya akun?</span>
    <a href="{{ route('login') }}" class="text-decoration-none fw-medium">Masuk</a>
    <div class="mt-2">
        <a href="{{ route('catalog.index') }}" class="text-muted text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Katalog
        </a>
    </div>
</div>
@endsection