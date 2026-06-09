@extends('layouts.app')

@section('title', 'Proses Pengembalian — Perpustakaan Digital')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Proses Pengembalian</h5>
        <p class="text-muted small mb-0">{{ $borrowing->borrow_number }}</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent fw-medium">Detail Peminjaman</div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">Anggota</dt>
                    <dd class="col-7 fw-medium">{{ $borrowing->member->name }}</dd>

                    <dt class="col-5 text-muted">No. Anggota</dt>
                    <dd class="col-7">{{ $borrowing->member->member_number }}</dd>

                    <dt class="col-5 text-muted">Buku</dt>
                    <dd class="col-7 fw-medium">{{ $borrowing->book->title }}</dd>

                    <dt class="col-5 text-muted">Pengarang</dt>
                    <dd class="col-7">{{ $borrowing->book->author }}</dd>

                    <dt class="col-5 text-muted">Tgl Pinjam</dt>
                    <dd class="col-7">{{ $borrowing->borrow_date->format('d/m/Y') }}</dd>

                    <dt class="col-5 text-muted">Batas Kembali</dt>
                    <dd class="col-7 {{ $borrowing->isLate() ? 'text-danger fw-medium' : '' }}">
                        {{ $borrowing->due_date->format('d/m/Y') }}
                        @if ($borrowing->isLate()) <span class="badge bg-danger ms-1">Terlambat</span> @endif
                    </dd>
                </dl>
            </div>
        </div>

        @if ($lateDays > 0)
            <div class="alert alert-warning border-0 shadow-sm">
                <div class="fw-medium"><i class="bi bi-exclamation-triangle me-2"></i>Ada Keterlambatan</div>
                <div class="small mt-1">
                    Terlambat <strong>{{ $lateDays }} hari</strong> ·
                    Denda: <strong>Rp {{ number_format($fineAmount, 0, ',', '.') }}</strong>
                    <div class="text-muted mt-1">Dihitung Rp 1.000/hari</div>
                </div>
            </div>
        @else
            <div class="alert alert-success border-0 shadow-sm">
                <i class="bi bi-check-circle me-2"></i>Pengembalian tepat waktu. Tidak ada denda.
            </div>
        @endif
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent fw-medium">Form Pengembalian</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('returns.store', $borrowing) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="return_date" class="form-label fw-medium">Tanggal Pengembalian <span class="text-danger">*</span></label>
                        <input type="date" id="return_date" name="return_date"
                               class="form-control @error('return_date') is-invalid @enderror"
                               value="{{ old('return_date', $returnDate) }}" required>
                        @error('return_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-medium">Catatan Kondisi Buku</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Opsional — misal: ada coretan, halaman sobek, dll">{{ old('notes') }}</textarea>
                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-arrow-return-left me-1"></i>Konfirmasi Pengembalian
                        </button>
                        <a href="{{ route('borrowings.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
