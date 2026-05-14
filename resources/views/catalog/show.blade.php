@extends('layouts.public')

@section('title', $book->title . ' — Perpustakaan Digital')

@section('content')
<div class="mb-3">
    <a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Katalog
    </a>
</div>

<div class="row g-4">
    <div class="col-md-3">
        @if ($book->cover_image)
            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                 class="img-fluid rounded shadow-sm w-100" style="max-height: 360px; object-fit: cover;">
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm"
                 style="height: 280px;">
                <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
            </div>
        @endif
    </div>

    <div class="col-md-9">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $book->title }}</h4>
                        <p class="text-muted mb-0">{{ $book->author }}</p>
                    </div>
                    @if ($book->available_stock > 0)
                        <span class="badge bg-success fs-6 px-3">Tersedia</span>
                    @else
                        <span class="badge bg-danger fs-6 px-3">Habis</span>
                    @endif
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <dl class="mb-0">
                            <dt class="text-muted small">Penerbit</dt>
                            <dd class="fw-medium">{{ $book->publisher }}</dd>

                            <dt class="text-muted small">ISBN</dt>
                            <dd>{{ $book->isbn ?? '-' }}</dd>

                            <dt class="text-muted small">Kategori</dt>
                            <dd>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $book->category }}</span>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl class="mb-0">
                            <dt class="text-muted small">Tahun Terbit</dt>
                            <dd class="fw-medium">{{ $book->year }}</dd>

                            <dt class="text-muted small">Lokasi Rak</dt>
                            <dd>{{ $book->location ?? '-' }}</dd>

                            <dt class="text-muted small">Stok Tersedia</dt>
                            <dd>
                                <span class="{{ $book->available_stock > 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ $book->available_stock }} / {{ $book->total_stock }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                </div>

                @if ($book->available_stock > 0)
                    <div class="alert alert-success mt-3 mb-0 small">
                        <i class="bi bi-info-circle me-2"></i>
                        Buku ini tersedia. Silakan hubungi petugas perpustakaan untuk melakukan peminjaman.
                    </div>
                @else
                    <div class="alert alert-warning mt-3 mb-0 small">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Stok buku sedang habis. Silakan cek kembali nanti.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
