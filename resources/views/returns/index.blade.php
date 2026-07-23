@extends('layouts.app')

@section('title', 'Pengembalian Buku — Perpustakaan Digital')
@section('page-title', 'Pengembalian Buku')
@section('page-subtitle', 'Scan/cari nomor peminjaman untuk proses pengembalian cepat')

@section('content')

{{-- QUICK RETURN FORM --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('returns.search') }}" id="quick-return-form">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <x-autocomplete
                        name="borrow_number"
                        id="borrow_number"
                        label="Nomor Peminjaman / Barcode Struk"
                        placeholder="Ketik nomor peminjaman, nama anggota, atau judul buku..."
                        searchUrl="{{ route('api.borrowings.search') }}"
                        :required="true"
                    />
                    <div class="form-text mt-2">Ketik untuk mencari, lalu pilih hasil untuk langsung proses pengembalian. Atau scan barcode struk lalu tekan Enter.</div>
                    <div class="mt-3" id="manual-submit-group" style="display:none;">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-search me-1"></i>Cari Data
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ACTIVE BORROWINGS TABLE --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold">Daftar Buku Belum Kembali</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('returns.index') }}" class="row g-2 mb-3 align-items-end">
            <div class="col-md-4">
                <x-search-bar placeholder="Cari anggota atau judul buku..." label="Cari" />
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label fw-medium mb-0">Urutkan</label>
                <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                    <option value="newest" @selected(request('sort', 'newest') === 'newest')>Paling Baru</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Paling Lama</option>
                    <option value="due_soonest" @selected(request('sort') === 'due_soonest')>Batas Kembali Paling Dekat</option>
                    <option value="due_latest" @selected(request('sort') === 'due_latest')>Batas Kembali Paling Jauh</option>
                    <option value="borrow_newest" @selected(request('sort') === 'borrow_newest')>Tanggal Pinjam Paling Baru</option>
                    <option value="borrow_oldest" @selected(request('sort') === 'borrow_oldest')>Tanggal Pinjam Paling Lama</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari Manual</button>
                @if(request()->hasAny(['search', 'sort']))
                    <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Peminjaman</th>
                        <th>Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th class="text-center" style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrowings as $borrowing)
                        <tr>
                            <td class="small fw-medium">
                                <a href="{{ route('borrowings.show', $borrowing) }}" class="text-decoration-none fw-semibold">
                                    {{ $borrowing->borrow_number }}
                                </a>
                            </td>
                            <td class="fw-medium">{{ $borrowing->member->name }}</td>
                            <td>
                                <div class="small">{{ $borrowing->book->title }}</div>
                            </td>
                            <td class="text-muted small">{{ $borrowing->borrow_date->translatedFormat('d/m/Y') }}</td>
                            <td class="small">
                                @if ($borrowing->isLate())
                                    <span class="text-danger fw-medium">{{ $borrowing->due_date->translatedFormat('d/m/Y') }}</span>
                                    <span class="badge bg-danger-subtle text-danger-emphasis ms-1">Terlambat</span>
                                @else
                                    {{ $borrowing->due_date->translatedFormat('d/m/Y') }}
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('returns.create', $borrowing) }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-arrow-return-left me-1"></i>Proses Return
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state icon="bi-check2-circle" message="Tidak ada buku yang sedang dipinjam saat ini." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination-wrap :paginator="$borrowings" />
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var baseUrl = '{{ url("borrowings") }}';

    // Auto-redirect saat autocomplete item dipilih
    var quickForm = document.getElementById('quick-return-form');
    if (quickForm) {
        var wrapper = quickForm.querySelector('.autocomplete-wrapper');
        if (wrapper) {
            wrapper.addEventListener('autocomplete:select', function (e) {
                var item = e.detail;
                if (item && item.id) {
                    window.location.href = baseUrl + '/' + item.id + '/return';
                }
            });
        }
    }

    // Toggle tombol "Cari Data" — tampilkan hanya saat user ketik manual (barcode)
    var borrowInput = document.querySelector('#quick-return-form .autocomplete-input');
    var submitGroup = document.getElementById('manual-submit-group');
    if (borrowInput && submitGroup) {
        borrowInput.addEventListener('input', function () {
            var q = this.value.trim();
            var hiddenVal = document.querySelector('#quick-return-form .autocomplete-value').value;
            // Tampilkan tombol jika user ketik >= 2 char tapi belum ada hidden value (belum pilih autocomplete)
            submitGroup.style.display = (q.length >= 2 && !hiddenVal) ? 'block' : 'none';
        });
        // Reset saat autocomplete clear
        var clearBtn = quickForm.querySelector('.autocomplete-clear');
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                submitGroup.style.display = 'none';
            });
        }
    }
});
</script>
@endpush
@endsection
