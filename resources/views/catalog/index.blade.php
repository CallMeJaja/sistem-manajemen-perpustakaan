@extends('layouts.public')

@section('title', 'Katalog Buku — Perpustakaan Digital')

@section('content')
<div class="row mb-3">
    <div class="col">
        <h5 class="fw-bold mb-0">Katalog Buku</h5>
        <p class="text-muted small mb-0">Temukan buku yang ingin kamu pinjam</p>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('catalog.index') }}" class="row g-2">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Cari judul, pengarang, atau kategori..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="availability" class="form-select">
                    <option value="">Semua Stok</option>
                    <option value="available" @selected(request('availability') === 'available')>Tersedia</option>
                    <option value="unavailable" @selected(request('availability') === 'unavailable')>Habis</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Cari</button>
                @if(request()->hasAny(['search', 'category', 'availability']))
                    <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

@if ($books->isNotEmpty())
    <div class="row g-3 mb-3">
        @foreach ($books as $book)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <a href="{{ route('catalog.show', $book) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 book-card">
                        <div class="position-relative">
                            @if ($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                     class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height: 200px;">
                                    <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            @if ($book->available_stock > 0)
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">Tersedia</span>
                            @else
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">Habis</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-title fw-semibold text-dark mb-1" style="line-height: 1.3;">{{ $book->title }}</h6>
                            <p class="text-muted small mb-1">{{ $book->author }}</p>
                            <span class="badge bg-secondary-subtle text-secondary-emphasis small">{{ $book->category }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{ $books->links() }}
@else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        Tidak ada buku yang ditemukan.
        @if(request()->hasAny(['search', 'category', 'availability']))
            <div class="mt-2">
                <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua Buku</a>
            </div>
        @endif
    </div>
@endif
@endsection

@push('styles')
<style>
    .book-card { transition: transform 0.15s ease, box-shadow 0.15s ease; }
    .book-card:hover { transform: translateY(-4px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.12) !important; }
</style>
@endpush
