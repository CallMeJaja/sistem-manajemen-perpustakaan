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
                    <option value="pending" @selected(request('status') === 'pending')>Menunggu Persetujuan</option>
                    <option value="borrowed" @selected(request('status') === 'borrowed')>Sedang Dipinjam</option>
                    <option value="returned" @selected(request('status') === 'returned')>Dikembalikan</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
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
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrowings as $borrowing)
                        <tr>
                            <td class="small fw-medium">
                                <a href="{{ route('borrowings.show', $borrowing) }}" class="text-decoration-none fw-semibold">
                                    {{ $borrowing->borrow_number }}
                                </a>
                            </td>
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
                                @php
                                    $statusMap = [
                                        'pending'  => ['Menunggu', 'bg-info-subtle text-info-emphasis'],
                                        'borrowed' => ['Dipinjam', 'bg-warning-subtle text-warning-emphasis'],
                                        'returned' => ['Kembali', 'bg-success-subtle text-success-emphasis'],
                                        'rejected' => ['Ditolak', 'bg-danger-subtle text-danger-emphasis'],
                                    ];
                                    [$statusLabel, $statusClass] = $statusMap[$borrowing->status] ?? [ucfirst($borrowing->status), 'bg-secondary-subtle text-secondary-emphasis'];
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group-action">
                                    <a href="{{ route('borrowings.show', $borrowing) }}"
                                       class="btn btn-sm btn-outline-primary" title="Detail Peminjaman">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if ($borrowing->status === 'pending')
                                        <form method="POST" action="{{ route('borrowings.approve', $borrowing) }}"
                                              onsubmit="return confirm('Setujui reservasi ini? Stok buku akan berkurang.')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Setujui Reservasi">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('borrowings.reject', $borrowing) }}"
                                              onsubmit="return confirm('Tolak reservasi ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Tolak Reservasi">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('borrowings.print', $borrowing) }}" target="_blank"
                                       class="btn btn-sm btn-outline-secondary" title="Cetak Struk">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    @if ($borrowing->status === 'borrowed')
                                        <a href="{{ route('returns.create', $borrowing) }}"
                                           class="btn btn-sm btn-outline-success" title="Proses Pengembalian">
                                            <i class="bi bi-arrow-return-left"></i>
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('borrowings.destroy', $borrowing) }}"
                                          onsubmit="return confirm('Hapus riwayat transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
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
                {{ $borrowings->links('pagination.custom') }}
            </div>
        @endif
    </div>
</div>
@endsection
