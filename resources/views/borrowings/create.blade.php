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
                <form method="POST" action="{{ route('borrowings.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="member_id" class="form-label fw-medium">Anggota <span class="text-danger">*</span></label>
                            <select id="member_id" name="member_id"
                                    class="form-select @error('member_id') is-invalid @enderror" required>
                                <option value="">— Pilih Anggota —</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>
                                        {{ $member->member_number }} — {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="book_id" class="form-label fw-medium">Buku <span class="text-danger">*</span></label>
                            <select id="book_id" name="book_id"
                                    class="form-select @error('book_id') is-invalid @enderror" required>
                                <option value="">— Pilih Buku —</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}" @selected(old('book_id') == $book->id)>
                                        {{ $book->title }} — {{ $book->author }} (Stok: {{ $book->available_stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('book_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if ($books->isEmpty())
                                <div class="form-text text-danger">Tidak ada buku yang tersedia saat ini.</div>
                            @endif
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
                        <button type="submit" class="btn btn-primary" {{ $books->isEmpty() ? 'disabled' : '' }}>
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
    document.addEventListener('DOMContentLoaded', function() {
        const borrowDateInput = document.getElementById('borrow_date');
        const dueDateInput = document.getElementById('due_date');

        // Set min borrow_date to today
        const today = new Date().toISOString().split('T')[0];
        borrowDateInput.setAttribute('min', today);

        borrowDateInput.addEventListener('change', function() {
            const borrowDate = new Date(this.value);
            if (isNaN(borrowDate.getTime())) return;

            // Automatically set due_date to +7 days
            const dueDate = new Date(borrowDate);
            dueDate.setDate(dueDate.getDate() + 7);

            const formattedDueDate = dueDate.toISOString().split('T')[0];
            dueDateInput.value = formattedDueDate;

            // Set min due_date to borrowDate
            dueDateInput.setAttribute('min', this.value);
        });

        // Ensure due_date min is also set on page load
        if (borrowDateInput.value) {
            dueDateInput.setAttribute('min', borrowDateInput.value);
        }
    });
</script>
@endpush
@endsection
