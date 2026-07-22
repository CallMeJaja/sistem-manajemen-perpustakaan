@extends('layouts.app')

@section('title', 'Kelola Buku — Perpustakaan Digital')
@section('page-title', 'Manajemen Buku')
@section('page-subtitle', 'Kelola seluruh koleksi buku perpustakaan')

@section('topbar-actions')
    <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tambah Buku
    </a>
@endsection

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('books.index') }}" class="row g-2 mb-3 align-items-end">
            <div class="col-md-4">
                <x-search-bar placeholder="Cari judul, pengarang, kategori..." label="Cari" />
            </div>
            <div class="col-md-2">
                <label for="availability" class="form-label small text-muted mb-0">Stok</label>
                <select name="availability" id="availability" class="form-select">
                    <option value="">Semua Stok</option>
                    <option value="available" @selected(request('availability') === 'available')>Tersedia</option>
                    <option value="unavailable" @selected(request('availability') === 'unavailable')>Habis</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label small text-muted mb-0">Urutkan</label>
                <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                    <option value="newest" @selected(request('sort', 'newest') === 'newest')>Paling Baru</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Paling Lama</option>
                    <option value="title_az" @selected(request('sort') === 'title_az')>Judul A-Z</option>
                    <option value="title_za" @selected(request('sort') === 'title_za')>Judul Z-A</option>
                    <option value="author_az" @selected(request('sort') === 'author_az')>Pengarang A-Z</option>
                    <option value="author_za" @selected(request('sort') === 'author_za')>Pengarang Z-A</option>
                    <option value="stock_most" @selected(request('sort') === 'stock_most')>Stok Terbanyak</option>
                    <option value="stock_least" @selected(request('sort') === 'stock_least')>Stok Paling Sedikit</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
                @if(request()->hasAny(['search', 'availability', 'sort']))
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px">Cover</th>
                        <th>Judul & Pengarang</th>
                        <th>Kategori</th>
                        <th>ISBN</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Tersedia</th>
                        <th class="text-center" style="width: 100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>
                                @if ($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                         class="rounded" style="width: 40px; height: 55px; object-fit: cover;">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                         style="width: 40px; height: 55px;">
                                        <i class="bi bi-book text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-medium">{{ $book->title }}</div>
                                <div class="text-muted small">{{ $book->author }} · {{ $book->year }}</div>
                            </td>
                            <td><span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $book->category }}</span></td>
                            <td class="text-muted small">{{ $book->isbn ?? '-' }}</td>
                            <td class="text-center">{{ $book->total_stock }}</td>
                            <td class="text-center">
                                @if ($book->available_stock > 0)
                                    <span class="badge bg-success-subtle text-success-emphasis">{{ $book->available_stock }}</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis">Habis</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <x-dropdown-aksi>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('books.edit', $book) }}">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('books.destroy', $book) }}" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Hapus buku ini?')">
                                                <i class="bi bi-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </x-dropdown-aksi>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-empty-state icon="bi-inbox" message="Belum ada data buku." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination-wrap :paginator="$books" />
    </div>
</div>
@endsection
