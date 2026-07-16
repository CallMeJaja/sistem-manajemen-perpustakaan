@extends('layouts.app')

@section('title', 'Peminjaman Aktif — Perpustakaan Digital')
@section('page-title', 'Peminjaman Aktif & Reservasi')
@section('page-subtitle', 'Kelola reservasi masuk dan buku yang sedang dipinjam')

@section('topbar-actions')
    <a href="{{ route('borrowings.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Catat Peminjaman
    </a>
@endsection

@section('content')

<ul class="nav nav-tabs mb-4 border-bottom-0">
    @php $currentStatus = request('status', 'all'); @endphp
    <li class="nav-item">
        <a class="nav-link {{ $currentStatus === 'all' ? 'active fw-bold' : 'text-muted' }}" 
           href="{{ route('borrowings.index') }}">Semua Aktif</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $currentStatus === 'pending' ? 'active fw-bold' : 'text-muted' }}" 
           href="{{ route('borrowings.index', ['status' => 'pending']) }}">Menunggu Persetujuan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $currentStatus === 'borrowed' ? 'active fw-bold' : 'text-muted' }}" 
           href="{{ route('borrowings.index', ['status' => 'borrowed']) }}">Sedang Dipinjam</a>
    </li>
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('borrowings.index') }}" class="row g-2 mb-3 align-items-end">
            <input type="hidden" name="status" value="{{ $currentStatus }}">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Cari nomor, anggota, atau judul buku..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="sort_by" class="form-select" onchange="this.form.submit()">
                    <option value="created_at" @selected(request('sort_by', 'created_at') === 'created_at')>Terbaru</option>
                    <option value="due_date" @selected(request('sort_by') === 'due_date')>Batas Kembali</option>
                    <option value="borrow_date" @selected(request('sort_by') === 'borrow_date')>Tgl Pinjam</option>
                    <option value="borrow_number" @selected(request('sort_by') === 'borrow_number')>No. Transaksi</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="order" class="form-select" onchange="this.form.submit()">
                    <option value="desc" @selected(request('order', 'desc') === 'desc')>Terbaru → Terlama</option>
                    <option value="asc" @selected(request('order') === 'asc')>Terlama → Terbaru</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                @if(request()->hasAny(['search', 'sort_by', 'order']))
                    <a href="{{ route('borrowings.index', ['status' => $currentStatus]) }}" class="btn btn-outline-secondary">Reset</a>
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
                            <td class="text-muted small">{{ $borrowing->borrow_date ? $borrowing->borrow_date->format('d/m/Y') : '-' }}</td>
                            <td class="small">
                                @if ($borrowing->due_date)
                                    @if ($borrowing->status === 'borrowed' && $borrowing->isLate())
                                        <span class="text-danger fw-medium">{{ $borrowing->due_date->format('d/m/Y') }}</span>
                                        <div class="text-danger" style="font-size: 0.7rem">Terlambat</div>
                                    @else
                                        {{ $borrowing->due_date->format('d/m/Y') }}
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $statusMap = [
                                        'pending'  => ['Menunggu', 'bg-info-subtle text-info-emphasis'],
                                        'borrowed' => ['Dipinjam', 'bg-warning-subtle text-warning-emphasis'],
                                        'returned' => ['Kembali', 'bg-success-subtle text-success-emphasis'],
                                        'rejected' => ['Ditolak', 'bg-danger-subtle text-danger-emphasis'],
                                        'cancelled' => ['Dibatalkan', 'bg-secondary-subtle text-secondary-emphasis'],
                                    ];
                                    [$statusLabel, $statusClass] = $statusMap[$borrowing->status] ?? [ucfirst($borrowing->status), 'bg-secondary-subtle text-secondary-emphasis'];
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
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

                                        @if ($borrowing->status === 'pending')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('borrowings.approve', $borrowing) }}" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Setujui reservasi ini? Stok buku akan berkurang.')">
                                                        <i class="bi bi-check-lg me-2 text-success"></i> Setujui Reservasi
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $borrowing->id }}">
                                                    <i class="bi bi-x-lg me-2 text-danger"></i> Tolak Reservasi
                                                </a>
                                            </li>
                                        @endif

                                        @if ($borrowing->status === 'borrowed')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('returns.create', $borrowing) }}">
                                                    <i class="bi bi-arrow-return-left me-2 text-success"></i> Proses Pengembalian
                                                </a>
                                            </li>
                                        @endif

                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('borrowings.destroy', $borrowing) }}" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Hapus riwayat transaksi ini?')">
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
                            <td colspan="7">
                                <x-empty-state icon="bi-journal-x" message="Belum ada transaksi peminjaman." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination-wrap :paginator="$borrowings" />
    </div>
</div>

{{-- Reject Modals --}}
@forelse ($borrowings as $borrowing)
    @if ($borrowing->status === 'pending')
    <div class="modal fade" id="rejectModal{{ $borrowing->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $borrowing->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('borrowings.reject', $borrowing) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel{{ $borrowing->id }}">Tolak Reservasi {{ $borrowing->borrow_number }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small mb-3">Anggota: <strong>{{ $borrowing->member->name }}</strong> — Buku: <strong>{{ $borrowing->book->title }}</strong></p>
                        <div class="mb-3">
                            <label for="rejection_reason{{ $borrowing->id }}" class="form-label">Alasan Penolakan <span class="text-muted">(opsional)</span></label>
                            <textarea class="form-control" id="rejection_reason{{ $borrowing->id }}" name="rejection_reason" rows="3" placeholder="Contoh: Stok buku sedang tidak tersedia, buku sedang dalam pemeliharaan..."></textarea>
                            <div class="form-text">Alasan akan ditampilkan kepada anggota di halaman riwayat pinjaman mereka.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-lg me-1"></i>Tolak Reservasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@empty
@endforelse
@endsection
