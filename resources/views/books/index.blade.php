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
        <form method="GET" action="{{ route('books.index') }}" class="row g-2 mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input
                        type="text"
                        name="search"
                        class="form-control border-start-0"
                        placeholder="Cari judul, pengarang, kategori..."
                        value="{{ request('search') }}"
                    >
                </div>
            </div>
            <div class="col-md-3">
                <select name="availability" class="form-select">
                    <option value="">Semua Stok</option>
                    <option value="available" @selected(request('availability') === 'available')>Tersedia</option>
                    <option value="unavailable" @selected(request('availability') === 'unavailable')>Habis</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
                @if(request()->hasAny(['search', 'availability']))
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
                        <th class="text-center" style="width: 120px">Aksi</th>
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
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('books.destroy', $book) }}" class="d-inline"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($books->hasPages())
            <div class="mt-3">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
