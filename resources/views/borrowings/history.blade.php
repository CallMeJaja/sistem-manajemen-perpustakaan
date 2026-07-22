@extends('layouts.app')

@section('title', 'Riwayat Transaksi — Perpustakaan Digital')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'Arsip seluruh peminjaman yang telah selesai atau ditolak')

@section('topbar-actions')
    <a href="{{ route('borrowings.report') }}" target="_blank" class="btn btn-secondary btn-sm">
        <i class="bi bi-printer me-1"></i>Cetak Laporan
    </a>
@endsection

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('borrowings.history') }}" class="row g-2 mb-3 align-items-end">
            <div class="col-md-4">
                <label for="history-search" class="form-label small text-muted mb-0">Cari</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" id="history-search" class="form-control border-start-0"
                           placeholder="Cari nomor, anggota, atau judul buku..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label small text-muted mb-0">Urutkan</label>
                <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                    <option value="newest" @selected(request('sort', 'newest') === 'newest')>Paling Baru</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Paling Lama</option>
                    <option value="due_soonest" @selected(request('sort') === 'due_soonest')>Batas Kembali Paling Dekat</option>
                    <option value="due_latest" @selected(request('sort') === 'due_latest')>Batas Kembali Paling Jauh</option>
                    <option value="borrow_newest" @selected(request('sort') === 'borrow_newest')>Tanggal Pinjam Paling Baru</option>
                    <option value="borrow_oldest" @selected(request('sort') === 'borrow_oldest')>Tanggal Pinjam Paling Lama</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                @if(request()->hasAny(['search', 'sort_by', 'order']))
                    <a href="{{ route('borrowings.history') }}" class="btn btn-outline-secondary">Reset</a>
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
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 100px">Aksi</th>
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
                            </td>
                            <td class="text-muted small">{{ $borrowing->borrow_date ? $borrowing->borrow_date->format('d/m/Y') : '-' }}</td>
                            <td class="text-muted small">
                                @if ($borrowing->status === 'returned' && $borrowing->return)
                                    {{ \Carbon\Carbon::parse($borrowing->return->return_date)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="small">
                                @if ($borrowing->status === 'returned' && $borrowing->return)
                                    @if ($borrowing->return->fine_amount > 0)
                                        <span class="text-danger fw-medium">Rp {{ number_format($borrowing->return->fine_amount, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-success">Rp 0</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($borrowing->status === 'returned')
                                    <span class="badge bg-success-subtle text-success-emphasis">Selesai</span>
                                @elseif ($borrowing->status === 'cancelled')
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis">Dibatalkan</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm text-sm">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('borrowings.show', $borrowing) }}">
                                                <i class="bi bi-eye me-2 text-primary"></i> Lihat Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('borrowings.print', $borrowing) }}" target="_blank">
                                                <i class="bi bi-printer me-2 text-secondary"></i> Cetak Struk
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('borrowings.destroy', $borrowing) }}" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Hapus riwayat arsip ini?')">
                                                    <i class="bi bi-trash me-2"></i> Hapus Data
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <x-empty-state icon="bi-archive" message="Belum ada riwayat transaksi." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination-wrap :paginator="$borrowings" />
    </div>
</div>
@endsection