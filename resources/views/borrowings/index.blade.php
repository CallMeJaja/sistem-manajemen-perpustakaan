@extends('layouts.app')

@section('title', 'Transaksi Peminjaman — Perpustakaan Digital')
@section('page-title', 'Transaksi Peminjaman')
@section('page-subtitle', 'Riwayat seluruh transaksi peminjaman buku')

@section('topbar-actions')
    <a href="{{ route('borrowings.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Catat Peminjaman
    </a>
@endsection

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('borrowings.index') }}" class="row g-2 mb-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Cari nomor, anggota, atau judul buku..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="borrowed" @selected(request('status') === 'borrowed')>Sedang Dipinjam</option>
                    <option value="returned" @selected(request('status') === 'returned')>Dikembalikan</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('borrowings.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Peminjaman</th>
                        <th>Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrowings as $borrowing)
                        <tr>
                            <td class="text-muted small fw-medium">{{ $borrowing->borrow_number }}</td>
                            <td class="fw-medium">{{ $borrowing->member->name }}</td>
                            <td>
                                <div class="small">{{ $borrowing->book->title }}</div>
                                <div class="text-muted" style="font-size: 0.75rem">{{ $borrowing->book->author }}</div>
                            </td>
                            <td class="text-muted small">{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                            <td class="small">
                                @if ($borrowing->status === 'borrowed' && $borrowing->isLate())
                                    <span class="text-danger fw-medium">{{ $borrowing->due_date->format('d/m/Y') }}</span>
                                    <div class="text-danger" style="font-size: 0.7rem">Terlambat</div>
                                @else
                                    {{ $borrowing->due_date->format('d/m/Y') }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($borrowing->status === 'borrowed')
                                    <span class="badge bg-warning-subtle text-warning-emphasis">Dipinjam</span>
                                @else
                                    <span class="badge bg-success-subtle text-success-emphasis">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($borrowing->status === 'borrowed')
                                    <a href="{{ route('returns.create', $borrowing) }}"
                                       class="btn btn-sm btn-outline-success" title="Proses Pengembalian">
                                        <i class="bi bi-arrow-return-left"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                Belum ada transaksi peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($borrowings->hasPages())
            <div class="mt-3">
                <x-pagination :paginator="$borrowings" />
            </div>
        @endif
    </div>
</div>
@endsection
