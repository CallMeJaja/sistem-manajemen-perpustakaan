@extends('layouts.auth')

@section('title', 'Login — GramediKu')
@section('logo', 'book-half')
@section('card-title', 'GramediKu')
@section('card-subtitle', 'Masuk ke akun GramediKu Anda')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <x-alert type="success" session="success" />
    <x-alert type="warning" session="info" />
    <x-alert type="error" session="error" />

    @error('verification')
        <div class="alert alert-warning d-flex align-items-start gap-2">
            <i class="bi bi-exclamation-triangle mt-1"></i>
            <div>
                {{ $message }}
                <br>
                <a href="{{ route('verification.resend') }}" class="alert-link small">
                    <i class="bi bi-envelope me-1"></i>Kirim Ulang Email Verifikasi
                </a>
            </div>
        </div>
    @enderror

    @error('approval')
        <div class="alert alert-info d-flex align-items-start gap-2">
            <i class="bi bi-info-circle mt-1"></i>
            <div>{{ $message }}</div>
        </div>
    @enderror

    <x-form-field name="email" label="Email" type="email" required placeholder="nama@email.com" autofocus />
    <x-form-field name="password" label="Password" type="password" required placeholder="••••••••" />

    <div class="mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label text-muted small" for="remember">Ingat saya</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
    </button>
</form>

<div class="text-center mt-4">
    <a href="{{ route('register') }}" class="text-muted small text-decoration-none d-block mb-2">
        <i class="bi bi-person-plus me-1"></i>Belum punya akun? Daftar
    </a>
    <a href="{{ route('password.request') }}" class="text-muted small text-decoration-none d-block mb-2">
        <i class="bi bi-key me-1"></i>Lupa password?
    </a>
    <a href="{{ route('catalog.index') }}" class="text-muted small text-decoration-none d-block">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Katalog
    </a>
</div>
@endsection