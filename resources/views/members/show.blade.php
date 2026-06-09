@extends('layouts.app')

@section('title', 'Detail Anggota — ' . $member->name)
@section('page-title', 'Detail Anggota')
@section('page-subtitle', 'Informasi profil dan riwayat peminjaman')

@section('topbar-actions')
    <a href="{{ route('members.edit', $member) }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-pencil me-1"></i>Edit Profil
    </a>
@endsection

@section('content')
<div class="row g-4">
    {{-- Profil Card --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-1 fw-bold" style="width:80px;height:80px;">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                </div>
                <h5 class="fw-bold mb-1">{{ $member->name }}</h5>
                <p class="text-muted small mb-3">{{ $member->member_number }}</p>

                <div class="badge {{ $member->hasActiveBorrowing() ? 'bg-warning-subtle text-warning-emphasis' : 'bg-success-subtle text-success-emphasis' }} px-3 py-2 rounded-pill mb-4">
                    {{ $member->hasActiveBorrowing() ? 'Ada Peminjaman Aktif' : 'Status: Aktif' }}
                </div>

                <div class="text-start border-top pt-4 mt-2">
                    <div class="mb-3">
                        <label class="text-muted small fw-medium d-block">Email</label>
                        <span>{{ $member->email }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small fw-medium d-block">Telepon</label>
                        <span>{{ $member->phone ?? '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small fw-medium d-block">Tanggal Bergabung</label>
                        <span>{{ $member->join_date->format('d M Y') }}</span>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small fw-medium d-block">Alamat</label>
                        <span class="small">{{ $member->address ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Peminjaman --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <span class="fw-bold">Riwayat Peminjaman</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th class="text-center">Status</th>
                            <th class="pe-4 text-end">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($borrowings as $borrowing)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-medium text-primary">{{ $borrowing->book->title }}</div>
                                    <div class="text-muted small">No: {{ $borrowing->borrow_number }}</div>
                                </td>
                                <td class="small">{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                                <td class="small">
                                    @if ($borrowing->status === 'returned')
                                        {{ $borrowing->return->return_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">{{ $borrowing->due_date->format('d/m/Y') }} (Batas)</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($borrowing->status === 'borrowed')
                                        <span class="badge bg-warning-subtle text-warning-emphasis">Dipinjam</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success-emphasis">Kembali</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end small fw-medium">
                                    @if ($borrowing->status === 'returned' && $borrowing->return->fine_amount > 0)
                                        <span class="text-danger">Rp {{ number_format($borrowing->return->fine_amount, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted italic">
                                    Belum ada riwayat peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($borrowings->hasPages())
                <div class="card-footer bg-white pt-0 border-0">
                    {{ $borrowings->links('pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
