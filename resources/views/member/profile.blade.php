@extends('layouts.member')

@section('title', 'Profil Saya — Member Portal')

@section('content')
<h4 class="fw-bold mb-3">Profil Saya</h4>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Data Anggota</div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">No. Anggota</dt>
                    <dd class="col-7">{{ $member->member_number }}</dd>
                    <dt class="col-5 text-muted">Nama</dt>
                    <dd class="col-7">{{ $member->name }}</dd>
                    <dt class="col-5 text-muted">Email</dt>
                    <dd class="col-7">{{ $member->email }}</dd>
                    <dt class="col-5 text-muted">Bergabung</dt>
                    <dd class="col-7">{{ $member->join_date->translatedFormat('d/m/Y') }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Edit Kontak</div>
            <div class="card-body">
                <form method="POST" action="{{ route('member.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $member->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Nama akan diperbarui di profil dan akun login Anda.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $member->email }}" disabled>
                        <div class="form-text">Email tidak dapat diubah karena digunakan sebagai akun login.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="tel" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $member->phone) }}" placeholder="08xxxxxxxxxx" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" rows="3"
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address', $member->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
