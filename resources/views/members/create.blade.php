@extends('layouts.app')

@section('title', 'Tambah Anggota — Perpustakaan Digital')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('members.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Tambah Anggota</h5>
        <p class="text-muted small mb-0">Daftarkan anggota baru</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('members.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="member_number" class="form-label fw-medium">Nomor Anggota <span class="text-danger">*</span></label>
                            <input type="text" id="member_number" name="member_number"
                                   class="form-control @error('member_number') is-invalid @enderror"
                                   value="{{ old('member_number', $nextNumber) }}" required>
                            @error('member_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="join_date" class="form-label fw-medium">Tanggal Bergabung <span class="text-danger">*</span></label>
                            <input type="date" id="join_date" name="join_date"
                                   class="form-control @error('join_date') is-invalid @enderror"
                                   value="{{ old('join_date', date('Y-m-d')) }}" required>
                            @error('join_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="name" class="form-label fw-medium">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-medium">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-medium">Telepon <span class="text-danger">*</span></label>
                            <input type="tel" id="phone" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label fw-medium">Alamat</label>
                            <textarea id="address" name="address" rows="3"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Opsional">{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy me-1"></i>Simpan
                        </button>
                        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const joinDateInput = document.getElementById('join_date');
        const today = new Date().toISOString().split('T')[0];
        joinDateInput.setAttribute('max', today);
    });
</script>
@endpush
@endsection
