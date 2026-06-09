@extends('layouts.app')

@section('title', 'Edit Buku — Perpustakaan Digital')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Edit Buku</h5>
        <p class="text-muted small mb-0">{{ $book->title }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title" class="form-label fw-medium">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $book->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="author" class="form-label fw-medium">Pengarang <span class="text-danger">*</span></label>
                            <input type="text" id="author" name="author"
                                   class="form-control @error('author') is-invalid @enderror"
                                   value="{{ old('author', $book->author) }}" required>
                            @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="publisher" class="form-label fw-medium">Penerbit <span class="text-danger">*</span></label>
                            <input type="text" id="publisher" name="publisher"
                                   class="form-control @error('publisher') is-invalid @enderror"
                                   value="{{ old('publisher', $book->publisher) }}" required>
                            @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="isbn" class="form-label fw-medium">ISBN</label>
                            <input type="text" id="isbn" name="isbn"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   value="{{ old('isbn', $book->isbn) }}">
                            @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <input type="text" id="category" name="category"
                                   class="form-control @error('category') is-invalid @enderror"
                                   value="{{ old('category', $book->category) }}" required>
                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="year" class="form-label fw-medium">Tahun Terbit <span class="text-danger">*</span></label>
                            <input type="number" id="year" name="year"
                                   class="form-control @error('year') is-invalid @enderror"
                                   value="{{ old('year', $book->year) }}" min="1900" max="{{ date('Y') }}" required>
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="total_stock" class="form-label fw-medium">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" id="total_stock" name="total_stock"
                                   class="form-control @error('total_stock') is-invalid @enderror"
                                   value="{{ old('total_stock', $book->total_stock) }}" min="1" required>
                            @error('total_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="location" class="form-label fw-medium">Lokasi Rak</label>
                            <input type="text" id="location" name="location"
                                   class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', $book->location) }}">
                            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="cover_image" class="form-label fw-medium">Cover Buku</label>
                            @if ($book->cover_image)
                                <div class="mb-2 d-flex align-items-center gap-3">
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="Cover"
                                         class="rounded" style="height: 80px; width: 58px; object-fit: cover;">
                                    <span class="text-muted small">Cover saat ini. Upload baru untuk mengganti.</span>
                                </div>
                            @endif
                            <input type="file" id="cover_image" name="cover_image" accept="image/*"
                                   class="form-control @error('cover_image') is-invalid @enderror">
                            <div class="form-text">Format: JPG, PNG, WEBP. Maks 2MB. Opsional.</div>
                            @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy me-1"></i>Perbarui
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
