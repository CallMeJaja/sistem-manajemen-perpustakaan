@extends('layouts.public')

@section('title', 'Verifikasi Email — GramediKu')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="mb-0"><i class="bi bi-envelope-check me-2"></i>Verifikasi Email</h5>
            </div>
            <div class="card-body p-4">
                @if (session('warning'))
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>Link verifikasi telah dikirim ke email Anda.
                    </div>
                @endif

                <p class="text-muted text-center mb-4">
                    Sebelum melanjutkan, silakan cek email Anda untuk link verifikasi.
                </p>

                <p class="text-muted text-center mb-4">
                    Jika tidak menerima email, kami dapat mengirim ulang.
                </p>

                <div class="text-center">
                    <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i>Kirim Ulang Email Verifikasi
                        </button>
                    </form>
                </div>

                <hr>

                <div class="text-center">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
