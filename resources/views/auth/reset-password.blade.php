@extends('layouts.auth')

@section('title', 'Reset Password — GramediKu')
@section('logo', 'key')
@section('card-title', 'Reset Password')
@section('card-subtitle', 'Masukkan password baru Anda')

@section('content')
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <x-alert type="error" session="error" />

    <x-form-field name="email" label="Email" type="email" required value="{{ $email ?? old('email') }}" />
    <x-form-field name="password" label="Password Baru" type="password" required placeholder="Minimal 8 karakter" />
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-check-lg me-2"></i>Reset Password
    </button>
</form>
@endsection