@extends('layouts.app')

@section('title', 'Pengembalian Buku — Perpustakaan Digital')
@section('page-title', 'Pengembalian Buku')
@section('page-subtitle', 'Scan/cari nomor peminjaman untuk proses pengembalian cepat')

@section('content')

{{-- QUICK RETURN FORM --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('returns.search') }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <label for="borrow_number" class="form-label fw-bold">Nomor Peminjaman / Barcode Struk</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" name="borrow_number" id="borrow_number" class="form-control"
                               placeholder="Contoh: PJ/20260711/0001" required autofocus autocomplete="off">
                        <button class="btn btn-primary px-4" type="submit">Cari Data</button>
                    </div>
                    <div class="form-text mt-2">Masukkan nomor peminjaman, lalu tekan Enter atau klik Cari Data. Sistem akan menampilkan detail transaksi pengembalian.</div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ACTIVE BORROWINGS TABLE --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold">Daftar Buku Belum Kembali</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('returns.index') }}" class="row g-2 mb-3">
            <div class="col-md-6">
                <x-search-bar placeholder="Cari anggota atau judul buku..." />
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari Manual</button>
                @if(request()->filled('search'))
                    <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                        <th class="text-center" style="width: 150px">Aksi</th>
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
                            <td class="text-muted small">{{ $borrowing->borrow_date->translatedFormat('d/m/Y') }}</td>
                            <td class="small">
                                @if ($borrowing->isLate())
                                    <span class="text-danger fw-medium">{{ $borrowing->due_date->translatedFormat('d/m/Y') }}</span>
                                    <span class="badge bg-danger-subtle text-danger-emphasis ms-1">Terlambat</span>
                                @else
                                    {{ $borrowing->due_date->translatedFormat('d/m/Y') }}
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('returns.create', $borrowing) }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-arrow-return-left me-1"></i>Proses Return
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state icon="bi-check2-circle" message="Tidak ada buku yang sedang dipinjam saat ini." />
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