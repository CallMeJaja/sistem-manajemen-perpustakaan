@extends('layouts.app')

@section('title', 'Catat Peminjaman — Perpustakaan Digital')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Catat Peminjaman</h5>
        <p class="text-muted small mb-0">Tambah transaksi peminjaman baru</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('borrowings.store') }}" id="borrowing-form">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <x-autocomplete
                                name="member_id"
                                id="member_id"
                                label="Anggota"
                                placeholder="Ketik nama, nomor, atau email anggota..."
                                searchUrl="{{ route('api.members.search') }}"
                                :required="true"
                                :oldValue="old('member_id')"
                            />
                            @error('member_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <x-autocomplete
                                name="book_id"
                                id="book_id"
                                label="Buku"
                                placeholder="Ketik judul, pengarang, atau ISBN buku..."
                                searchUrl="{{ route('api.books.search') }}"
                                :required="true"
                                :oldValue="old('book_id')"
                            />
                            @error('book_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="borrow_date" class="form-label fw-medium">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" id="borrow_date" name="borrow_date"
                                   class="form-control @error('borrow_date') is-invalid @enderror"
                                   value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                            @error('borrow_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="due_date" class="form-label fw-medium">Batas Pengembalian <span class="text-danger">*</span></label>
                            <input type="date" id="due_date" name="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                            @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy me-1"></i>Simpan
                        </button>
                        <a href="{{ route('borrowings.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var borrowDateInput = document.getElementById('borrow_date');
        var dueDateInput = document.getElementById('due_date');
        var today = new Date().toISOString().split('T')[0];
        borrowDateInput.setAttribute('min', today);

        borrowDateInput.addEventListener('change', function() {
            var borrowDate = new Date(this.value);
            if (isNaN(borrowDate.getTime())) return;
            var dueDate = new Date(borrowDate);
            dueDate.setDate(dueDate.getDate() + 7);
            dueDateInput.value = dueDate.toISOString().split('T')[0];
            dueDateInput.setAttribute('min', this.value);
        });

        if (borrowDateInput.value) {
            dueDateInput.setAttribute('min', borrowDateInput.value);
        }
    });
</script>
@endpush
@endsection
