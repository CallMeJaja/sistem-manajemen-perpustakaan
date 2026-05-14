@extends('layouts.app')

@section('title', 'Tambah Buku — Perpustakaan Digital')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Tambah Buku</h5>
        <p class="text-muted small mb-0">Isi data buku baru</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title" class="form-label fw-medium">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="author" class="form-label fw-medium">Pengarang <span class="text-danger">*</span></label>
                            <input type="text" id="author" name="author"
                                   class="form-control @error('author') is-invalid @enderror"
                                   value="{{ old('author') }}" required>
                            @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="publisher" class="form-label fw-medium">Penerbit <span class="text-danger">*</span></label>
                            <input type="text" id="publisher" name="publisher"
                                   class="form-control @error('publisher') is-invalid @enderror"
                                   value="{{ old('publisher') }}" required>
                            @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="isbn" class="form-label fw-medium">ISBN</label>
                            <input type="text" id="isbn" name="isbn"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   value="{{ old('isbn') }}" placeholder="Opsional">
                            @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <input type="text" id="category" name="category"
                                   class="form-control @error('category') is-invalid @enderror"
                                   value="{{ old('category') }}" required>
                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="year" class="form-label fw-medium">Tahun Terbit <span class="text-danger">*</span></label>
                            <input type="number" id="year" name="year"
                                   class="form-control @error('year') is-invalid @enderror"
                                   value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') }}" required>
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="total_stock" class="form-label fw-medium">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" id="total_stock" name="total_stock"
                                   class="form-control @error('total_stock') is-invalid @enderror"
                                   value="{{ old('total_stock', 1) }}" min="1" required>
                            @error('total_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="location" class="form-label fw-medium">Lokasi Rak</label>
                            <input type="text" id="location" name="location"
                                   class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location') }}" placeholder="Contoh: A-01">
                            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="cover_image" class="form-label fw-medium">Cover Buku</label>
                            <input type="file" id="cover_image" name="cover_image" accept="image/*"
                                   class="form-control @error('cover_image') is-invalid @enderror">
                            <div class="form-text">Format: JPG, PNG, WEBP. Maks 2MB. Opsional.</div>
                            @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy me-1"></i>Simpan
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
