@extends('layouts.public')

@section('title', 'Katalog Buku — GramediKu')

@section('hero')
<div class="public-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1><i class="bi bi-book-half me-2"></i>Katalog Buku</h1>
                <p>Temukan buku favoritmu dari koleksi perpustakaan digital GramediKu.</p>

                <div class="search-bar-hero">
                    <form method="GET" action="{{ route('catalog.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label for="catalog-search" class="form-label small mb-0">Cari</label>
                            <input type="text" name="search" id="catalog-search" class="form-control"
                                   placeholder="Cari judul, pengarang..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label small mb-0">Kategori</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="catalog-availability" class="form-label small mb-0">Stok</label>
                            <select name="availability" id="catalog-availability" class="form-select">
                                <option value="">Semua Stok</option>
                                <option value="available" @selected(request('availability') === 'available')>Tersedia</option>
                                <option value="unavailable" @selected(request('availability') === 'unavailable')>Habis</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-flex justify-content-end">
                <div style="font-size:9rem;opacity:.15;"><i class="bi bi-journal-bookmark-fill"></i></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-3">
    <div>
        @if(request()->hasAny(['search', 'category', 'availability']))
            <span class="text-muted small">
                Menampilkan <strong>{{ $books->total() }}</strong> hasil pencarian
                &nbsp;·&nbsp;
                <a href="{{ route('catalog.index') }}" class="text-decoration-none">Reset filter</a>
            </span>
        @else
            <span class="text-muted small">Menampilkan <strong>{{ $books->total() }}</strong> koleksi buku</span>
        @endif
    </div>
    <div>
        <form method="GET" action="{{ route('catalog.index') }}" class="d-flex align-items-center gap-2">
            @if(request()->filled('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
            @if(request()->filled('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
            @if(request()->filled('availability'))<input type="hidden" name="availability" value="{{ request('availability') }}">@endif
            <label for="per_page" class="text-muted small text-nowrap">Tampil:</label>
            <select name="per_page" id="per_page" class="form-select form-select-sm" style="min-width: 70%;" onchange="this.form.submit()">
                @foreach([10, 15, 20, 25, 50, 100] as $n)
                    <option value="{{ $n }}" @selected(request('per_page', 12) == $n)>{{ $n }}</option>
                @endforeach
            </select>
        </form>
    </div>
</div>

@if ($books->isNotEmpty())
    <div class="row g-3 mb-4">
        @foreach ($books as $book)
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <a href="{{ route('catalog.show', $book) }}" class="text-decoration-none">
                    <div class="book-card-public">
                        <div class="book-card-cover">
                            @if ($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}">
                            @else
                                <div class="book-card-cover-placeholder">
                                    <i class="bi bi-book"></i>
                                </div>
                            @endif
                            @if ($book->available_stock > 0)
                                <span class="book-badge-availability" style="background:#f0fdf4;color:#166534;">Tersedia</span>
                            @else
                                <span class="book-badge-availability" style="background:#fff1f2;color:#991b1b;">Habis</span>
                            @endif
                        </div>
                        <div class="book-card-body">
                            <div class="book-card-title">{{ $book->title }}</div>
                            <div class="book-card-author">{{ $book->author }}</div>
                            <span class="badge book-card-category" style="background:#eff6ff;color:#1d4ed8;">{{ $book->category }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    {{ $books->links('pagination.custom') }}
@else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox" style="font-size:3.5rem;display:block;margin-bottom:12px;opacity:.4;"></i>
        <div class="fw-medium">Tidak ada buku yang ditemukan.</div>
        @if(request()->hasAny(['search', 'category', 'availability']))
            <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-secondary mt-3">Lihat Semua Buku</a>
        @endif
    </div>
@endif
@endsection
