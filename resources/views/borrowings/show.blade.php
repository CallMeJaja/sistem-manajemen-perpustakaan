@extends('layouts.app')

@section('title', 'Detail Transaksi Peminjaman — ' . $borrowing->borrow_number)
@section('page-title', 'Detail Transaksi Peminjaman')
@section('page-subtitle', 'Rincian data transaksi peminjaman buku')

@section('topbar-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('borrowings.print', $borrowing) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-1"></i>Cetak Struk
        </a>
        @if ($borrowing->status === 'borrowed')
            <a href="{{ route('returns.create', $borrowing) }}" class="btn btn-success btn-sm">
                <i class="bi bi-arrow-return-left me-1"></i>Proses Pengembalian
            </a>
        @endif
    </div>
@endsection

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    {{-- Main details --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary">Informasi Peminjaman</span>
                @if ($borrowing->status === 'borrowed')
                    @if ($borrowing->isLate())
                        <span class="badge bg-danger">Terlambat</span>
                    @else
                        <span class="badge bg-warning text-dark">Dipinjam</span>
                    @endif
                @else
                    <span class="badge bg-success">Sudah Dikembalikan</span>
                @endif
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="text-muted small fw-medium d-block">Nomor Transaksi</label>
                        <span class="fs-5 fw-bold text-dark">{{ $borrowing->borrow_number }}</span>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <label class="text-muted small fw-medium d-block">Tanggal Transaksi</label>
                        <span class="text-dark">{{ $borrowing->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <hr>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-medium d-block">Tanggal Pinjam</label>
                        <span class="fw-medium text-dark"><i class="bi bi-calendar-event me-2 text-primary"></i>{{ $borrowing->borrow_date->format('d F Y') }}</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-medium d-block">Batas Pengembalian</label>
                        <span class="fw-medium {{ $borrowing->isLate() ? 'text-danger' : 'text-dark' }}">
                            <i class="bi bi-calendar-check me-2 {{ $borrowing->isLate() ? 'text-danger' : 'text-primary' }}"></i>{{ $borrowing->due_date->format('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if ($borrowing->status === 'returned' && $borrowing->return)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <span class="fw-bold text-success">Detail Pengembalian</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="text-muted small fw-medium d-block">Tanggal Kembali</label>
                            <span class="fw-medium text-dark"><i class="bi bi-calendar2-check-fill me-2 text-success"></i>{{ $borrowing->return->return_date->format('d F Y') }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small fw-medium d-block">Denda</label>
                            @if ($borrowing->return->fine_amount > 0)
                                <span class="fw-bold text-danger">Rp {{ number_format($borrowing->return->fine_amount, 0, ',', '.') }} (Terlambat {{ $borrowing->return->late_days }} hari)</span>
                            @else
                                <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i> Tepat waktu / Tanpa denda</span>
                            @endif
                        </div>
                        <div class="col-12 mt-3">
                            <label class="text-muted small fw-medium d-block">Catatan Kondisi</label>
                            <div class="p-3 bg-light rounded border-start border-success border-3 text-secondary small">
                                {{ $borrowing->return->notes ?? 'Tidak ada catatan kondisi buku.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Side Cards for Member and Book details --}}
    <div class="col-lg-4">
        {{-- Member Detail Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <span class="fw-bold text-secondary"><i class="bi bi-person me-1"></i>Informasi Anggota</span>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fw-bold" style="width: 48px; height: 48px;">
                        {{ strtoupper(substr($borrowing->member->name, 0, 1)) }}
                    </div>
                    <div>
                        <a href="{{ route('members.show', $borrowing->member) }}" class="fw-bold text-decoration-none text-dark d-block">{{ $borrowing->member->name }}</a>
                        <small class="text-muted">{{ $borrowing->member->member_number }}</small>
                    </div>
                </div>
                <div class="small">
                    <div class="mb-2">
                        <span class="text-muted d-block">Email</span>
                        <span class="text-dark">{{ $borrowing->member->email }}</span>
                    </div>
                    <div class="mb-0">
                        <span class="text-muted d-block">Telepon</span>
                        <span class="text-dark">{{ $borrowing->member->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Book Detail Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <span class="fw-bold text-secondary"><i class="bi bi-book me-1"></i>Informasi Buku</span>
            </div>
            <div class="card-body">
                <div class="d-flex gap-3 mb-3">
                    @if ($borrowing->book->cover_image)
                        <div class="flex-shrink-0" style="width: 60px; height: 80px; overflow: hidden; border-radius: 6px; border: 1px solid #e2e8f0;">
                            <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}" class="w-100 h-100 object-fit-cover">
                        </div>
                    @else
                        <div class="flex-shrink-0 bg-light d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 80px; border: 1px solid #e2e8f0;">
                            <i class="bi bi-book text-muted fs-4"></i>
                        </div>
                    @endif
                    <div>
                        <span class="fw-bold text-dark d-block line-clamp-2" style="font-size: 0.9rem;">{{ $borrowing->book->title }}</span>
                        <small class="text-muted d-block">Oleh: {{ $borrowing->book->author }}</small>
                        <span class="badge bg-secondary-subtle text-secondary-emphasis" style="font-size: 0.65rem;">{{ $borrowing->book->category }}</span>
                    </div>
                </div>
                <div class="small">
                    <div class="mb-2">
                        <span class="text-muted d-block">Penerbit</span>
                        <span class="text-dark">{{ $borrowing->book->publisher }} ({{ $borrowing->book->year }})</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted d-block">ISBN</span>
                        <span class="text-dark">{{ $borrowing->book->isbn ?? '-' }}</span>
                    </div>
                    <div class="mb-0">
                        <span class="text-muted d-block">Lokasi Rak</span>
                        <span class="text-dark"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $borrowing->book->location ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
