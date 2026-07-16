@extends('layouts.auth')

@section('title', 'Lupa Password — GramediKu')
@section('logo', 'key')
@section('card-title', 'Lupa Password?')
@section('card-subtitle', 'Masukkan email Anda untuk menerima tautan reset password')

@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <x-alert type="success" session="success" />
    <x-alert type="error" session="error" />

    <x-form-field name="email" label="Email" type="email" required placeholder="nama@email.com" autofocus />

    <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-send me-2"></i>Kirim Tautan Reset
    </button>
</form>

<div class="text-center">
    <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
    </a>
</div>
@endsection