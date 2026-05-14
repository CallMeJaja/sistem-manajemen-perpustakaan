@extends('layouts.app')

@section('title', 'Kelola Anggota — Perpustakaan Digital')
@section('page-title', 'Manajemen Anggota')
@section('page-subtitle', 'Kelola seluruh data anggota perpustakaan')

@section('topbar-actions')
    <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i>Tambah Anggota
    </a>
@endsection

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('members.index') }}" class="row g-2 mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input
                        type="text"
                        name="search"
                        class="form-control border-start-0"
                        placeholder="Cari nama, email, nomor anggota..."
                        value="{{ request('search') }}"
                    >
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                @if(request()->filled('search'))
                    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Bergabung</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td class="text-muted small fw-medium">{{ $member->member_number }}</td>
                            <td class="fw-medium">{{ $member->name }}</td>
                            <td class="text-muted small">{{ $member->email }}</td>
                            <td class="text-muted small">{{ $member->phone ?? '-' }}</td>
                            <td class="text-muted small">{{ $member->join_date->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @if ($member->hasActiveBorrowing())
                                    <span class="badge bg-warning-subtle text-warning-emphasis">Meminjam</span>
                                @else
                                    <span class="badge bg-success-subtle text-success-emphasis">Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group-action">
                                    <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('members.destroy', $member) }}"
                                          onsubmit="return confirm('Hapus anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"
                                            {{ $member->hasActiveBorrowing() ? 'disabled' : '' }}>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                Belum ada data anggota.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($members->hasPages())
            <div class="mt-3">
                {{ $members->links('pagination.custom') }}
            </div>
        @endif
    </div>
</div>
@endsection
