@extends('layouts.member')

@section('title', 'Dashboard — Member Portal')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Halo, {{ $member->name }} 👋</h4>
        <p class="text-muted mb-0 small">No. Anggota: <span class="fw-medium">{{ $member->member_number }}</span></p>
    </div>
    <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-search me-1"></i>Cari Buku
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Menunggu</div>
                <div class="fs-3 fw-bold text-info">{{ $stats['pending'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Sedang Dipinjam</div>
                <div class="fs-3 fw-bold text-warning">{{ $stats['borrowed'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Selesai</div>
                <div class="fs-3 fw-bold text-success">{{ $stats['returned'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
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
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3 py-md-2 border-bottom gap-2">
                <div>
                    <div class="fw-medium">{{ $b->book->title }}</div>
                    <div class="text-muted small text-nowrap">{{ $b->borrow_number }} &middot; Batas: {{ $b->due_date->translatedFormat('d/m/Y') }}</div>
                </div>
                <div class="text-start text-md-end w-100 w-md-auto d-flex justify-content-between justify-content-md-end align-items-center gap-2">
                    @if ($b->status === 'pending')
                        <span class="badge bg-info-subtle text-info-emphasis">Menunggu</span>
                        <form method="POST" action="{{ route('member.borrowings.cancel', $b) }}" class="m-0"
                              onsubmit="return confirm('Batalkan reservasi ini?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">Batalkan</button>
                        </form>
                    @elseif ($b->status === 'borrowed' && $b->isLate())
                        <span class="badge bg-danger-subtle text-danger-emphasis">Terlambat</span>
                    @elseif ($b->status === 'rejected')
                        <span class="badge bg-danger-subtle text-danger-emphasis">Ditolak</span>
                        @if ($b->rejection_reason)
                            <span class="text-muted small d-block">Alasan: {{ $b->rejection_reason }}</span>
                        @endif
                    @elseif ($b->status === 'cancelled')
                        <span class="badge bg-secondary-subtle text-secondary-emphasis">Dibatalkan</span>
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
