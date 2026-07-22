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
        <form method="GET" action="{{ route('members.index') }}" class="row g-2 mb-3 align-items-end">
            <div class="col-md-4">
                <x-search-bar placeholder="Cari nama, email, nomor anggota..." label="Cari" />
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label small text-muted mb-0">Urutkan</label>
                <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                    <option value="newest" @selected(request('sort', 'newest') === 'newest')>Paling Baru</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Paling Lama</option>
                    <option value="name_az" @selected(request('sort') === 'name_az')>Nama A-Z</option>
                    <option value="name_za" @selected(request('sort') === 'name_za')>Nama Z-A</option>
                    <option value="member_number" @selected(request('sort') === 'member_number')>Nomor Anggota</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                @if(request()->hasAny(['search', 'sort']))
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
                        <th class="text-center">Status Akun</th>
                        <th class="text-center">Peminjaman</th>
                        <th class="text-center" style="width: 100px">Aksi</th>
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
                                @php $status = $member->user?->status; @endphp
                                @if ($status === 'approved')
                                    <span class="badge bg-success-subtle text-success-emphasis">Disetujui</span>
                                @elseif ($status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning-emphasis">Pending</span>
                                @elseif ($status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger-emphasis">Ditolak</span>
                                @elseif ($member->user)
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis">Tanpa Status</span>
                                @else
                                    <span class="badge bg-light text-muted">Belum Ada Akun</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($member->hasActiveBorrowing())
                                    <span class="badge bg-warning-subtle text-warning-emphasis">Meminjam</span>
                                @else
                                    <span class="badge bg-success-subtle text-success-emphasis">Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm text-sm">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('members.show', $member) }}">
                                                <i class="bi bi-eye me-2 text-primary"></i> Lihat Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('members.edit', $member) }}">
                                                <i class="bi bi-pencil me-2 text-secondary"></i> Edit
                                            </a>
                                        </li>

                                        @if ($member->user && $member->user->status === 'pending')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('members.approve', $member) }}" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-check-lg me-2 text-success"></i> Setujui Akun
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('members.reject', $member) }}" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menolak akun anggota ini?')">
                                                        <i class="bi bi-x-lg me-2 text-danger"></i> Tolak Akun
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        @if (!$member->user || $member->user->status !== 'pending')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('members.destroy', $member) }}" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" {{ $member->hasActiveBorrowing() ? 'disabled' : '' }} onclick="return confirm('Hapus anggota ini?')">
                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                                    <td colspan="8">
                                <x-empty-state icon="bi-people" message="Belum ada data anggota." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination-wrap :paginator="$members" />
    </div>
</div>
@endsection
