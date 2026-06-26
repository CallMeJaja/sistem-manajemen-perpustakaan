@extends('layouts.member')

@section('title', 'Dashboard — Member Portal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Halo, {{ $member->name }} 👋</h4>
        <p class="text-muted mb-0 small">No. Anggota: <span class="fw-medium">{{ $member->member_number }}</span></p>
    </div>
    <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-search me-1"></i>Cari Buku
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Menunggu</div>
                <div class="fs-3 fw-bold text-info">{{ $stats['pending'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Sedang Dipinjam</div>
                <div class="fs-3 fw-bold text-warning">{{ $stats['borrowed'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Selesai</div>
                <div class="fs-3 fw-bold text-success">{{ $stats['returned'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Total Denda</div>
                <div class="fs-5 fw-bold text-danger">Rp {{ number_format($stats['total_fine'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Reservasi & Pinjaman Aktif</div>
    <div class="card-body">
        @forelse ($activeBorrowings as $b)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    <div class="fw-medium">{{ $b->book->title }}</div>
                    <div class="text-muted small">{{ $b->borrow_number }} &middot; Batas: {{ $b->due_date->format('d/m/Y') }}</div>
                </div>
                <div class="text-end">
                    @if ($b->status === 'pending')
                        <span class="badge bg-info-subtle text-info-emphasis">Menunggu</span>
                        <form method="POST" action="{{ route('member.borrowings.cancel', $b) }}" class="d-inline"
                              onsubmit="return confirm('Batalkan reservasi ini?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger ms-1">Batalkan</button>
                        </form>
                    @elseif ($b->status === 'borrowed' && $b->isLate())
                        <span class="badge bg-danger-subtle text-danger-emphasis">Terlambat</span>
                    @else
                        <span class="badge bg-warning-subtle text-warning-emphasis">Dipinjam</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted text-center mb-0 py-3">Belum ada reservasi atau pinjaman aktif.
                <a href="{{ route('catalog.index') }}">Cari buku</a>.</p>
        @endforelse
    </div>
</div>
@endsection
