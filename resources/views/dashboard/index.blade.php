@extends('layouts.app')

@section('title', 'Dashboard — Perpustakaan Digital')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h5 class="fw-bold mb-0">Dashboard</h5>
        <p class="text-muted small mb-0">Ringkasan data perpustakaan</p>
    </div>
</div>

<div class="row g-3">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-books text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Buku</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_books'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-success bg-opacity-10 p-3">
                    <i class="bi bi-book text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Buku Tersedia</p>
                    <h4 class="fw-bold mb-0">{{ $stats['available_books'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-info bg-opacity-10 p-3">
                    <i class="bi bi-people text-info fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Anggota</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_members'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-clock-history text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Sedang Dipinjam</p>
                    <h4 class="fw-bold mb-0">{{ $stats['active_borrowings'] }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
