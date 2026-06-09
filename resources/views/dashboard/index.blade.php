@extends('layouts.app')

@section('title', 'Dashboard — Perpustakaan Digital')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h5 class="fw-bold mb-0">Dashboard</h5>
        <p class="text-muted small mb-0">Ringkasan data perpustakaan</p>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 p-3 flex-shrink-0">
                    <i class="bi bi-books text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Buku</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_books'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-success bg-opacity-10 p-3 flex-shrink-0">
                    <i class="bi bi-book text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Tersedia</p>
                    <h4 class="fw-bold mb-0">{{ $stats['available_books'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-info bg-opacity-10 p-3 flex-shrink-0">
                    <i class="bi bi-people text-info fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Anggota</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_members'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-warning bg-opacity-10 p-3 flex-shrink-0">
                    <i class="bi bi-clock-history text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Dipinjam</p>
                    <h4 class="fw-bold mb-0">{{ $stats['active_borrowings'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-secondary bg-opacity-10 p-3 flex-shrink-0">
                    <i class="bi bi-check2-circle text-secondary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Dikembalikan</p>
                    <h4 class="fw-bold mb-0">{{ $stats['returned_borrowings'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2">
        <a href="{{ route('borrowings.index', ['status' => 'borrowed']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 {{ $stats['late_borrowings'] > 0 ? 'border-danger border' : '' }}">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-danger bg-opacity-10 p-3 flex-shrink-0">
                        <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Terlambat</p>
                        <h4 class="fw-bold mb-0 {{ $stats['late_borrowings'] > 0 ? 'text-danger' : '' }}">
                            {{ $stats['late_borrowings'] }}
                        </h4>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- Charts --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Peminjaman 6 Bulan Terakhir</h6>
                <canvas id="borrowingChart" height="110"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Kategori Buku</h6>
                @if ($bookCategories->isNotEmpty())
                    <canvas id="categoryChart" height="200"></canvas>
                @else
                    <div class="d-flex align-items-center justify-content-center h-75 text-muted small">
                        Belum ada data buku.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Tables --}}
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Transaksi Terbaru</span>
                <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Anggota</th>
                                <th>Buku</th>
                                <th class="pe-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentBorrowings as $borrowing)
                                <tr>
                                    <td class="ps-3">{{ $borrowing->member->name }}</td>
                                    <td class="text-truncate" style="max-width: 160px">{{ $borrowing->book->title }}</td>
                                    <td class="pe-3 text-center">
                                        @if ($borrowing->status === 'borrowed')
                                            <span class="badge bg-warning-subtle text-warning-emphasis">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success-emphasis">Kembali</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <span class="fw-semibold text-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>Peminjaman Terlambat
                </span>
                <a href="{{ route('borrowings.index', ['status' => 'borrowed']) }}" class="btn btn-sm btn-outline-danger">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Anggota</th>
                                <th>Buku</th>
                                <th class="pe-3 text-center">Batas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lateBorrowings as $borrowing)
                                <tr class="table-danger-subtle">
                                    <td class="ps-3">{{ $borrowing->member->name }}</td>
                                    <td class="text-truncate" style="max-width: 160px">{{ $borrowing->book->title }}</td>
                                    <td class="pe-3 text-center text-danger fw-medium">
                                        {{ $borrowing->due_date->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="bi bi-check-circle text-success me-1"></i>Tidak ada keterlambatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const borrowingCtx = document.getElementById('borrowingChart');
    new Chart(borrowingCtx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($monthTotals),
                backgroundColor: 'rgba(13, 110, 253, 0.15)',
                borderColor: 'rgba(13, 110, 253, 0.8)',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });

    @if ($bookCategories->isNotEmpty())
    const categoryCtx = document.getElementById('categoryChart');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: @json($bookCategories->pluck('category')),
            datasets: [{
                data: @json($bookCategories->pluck('total')),
                backgroundColor: [
                    '#0d6efd', '#198754', '#ffc107', '#0dcaf0', '#dc3545', '#6c757d'
                ],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });
    @endif
</script>
@endpush
