@extends('layouts.auth')

@section('title', 'Kirim Ulang Verifikasi — GramediKu')
@section('logo', 'envelope')
@section('card-title', 'Verifikasi Email')
@section('card-subtitle', 'Kirim ulang tautan verifikasi ke email Anda')

@section('content')
<form method="POST" action="{{ route('verification.send') }}">
    @csrf

    <x-alert type="success" session="success" />

    <x-form-field name="email" label="Email Terdaftar" type="email" required placeholder="nama@email.com" autofocus />

    <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-send me-2"></i>Kirim Tautan
    </button>
</form>

<div class="text-center">
    <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
    </a>
</div>
@endsection