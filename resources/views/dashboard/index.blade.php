@extends('layouts.app')

@section('title', 'Dashboard — Perpustakaan Digital')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data perpustakaan')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-2">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-card-icon" style="background:#eff6ff;">
                <i class="bi bi-book" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Total Buku</div>
                <div class="fw-bold" style="font-size:1.5rem;line-height:1.2;">{{ $stats['total_books'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-card-icon" style="background:#f0fdf4;">
                <i class="bi bi-book" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Tersedia</div>
                <div class="fw-bold" style="font-size:1.5rem;line-height:1.2;">{{ $stats['available_books'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-card-icon" style="background:#eff6ff;">
                <i class="bi bi-people" style="color:#0284c7;"></i>
            </div>
            <div>
                <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Anggota</div>
                <div class="fw-bold" style="font-size:1.5rem;line-height:1.2;">{{ $stats['total_members'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-card-icon" style="background:#fffbeb;">
                <i class="bi bi-clock-history" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Dipinjam</div>
                <div class="fw-bold" style="font-size:1.5rem;line-height:1.2;">{{ $stats['active_borrowings'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-card-icon" style="background:#f0fdf4;">
                <i class="bi bi-check2-circle" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Kembali</div>
                <div class="fw-bold" style="font-size:1.5rem;line-height:1.2;">{{ $stats['returned_borrowings'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <a href="{{ route('borrowings.index', ['status' => 'borrowed']) }}" class="text-decoration-none">
            <div class="stat-card d-flex align-items-center gap-3 {{ $stats['late_borrowings'] > 0 ? 'border-danger' : '' }}" style="{{ $stats['late_borrowings'] > 0 ? 'border-color:#ef4444!important;' : '' }}">
                <div class="stat-card-icon" style="background:#fff1f2;">
                    <i class="bi bi-exclamation-triangle" style="color:#dc2626;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Terlambat</div>
                    <div class="fw-bold {{ $stats['late_borrowings'] > 0 ? 'text-danger' : '' }}" style="font-size:1.5rem;line-height:1.2;">{{ $stats['late_borrowings'] }}</div>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- Charts --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Peminjaman 6 Bulan Terakhir</span>
            </div>
            <div class="card-body">
                <canvas id="borrowingChart" height="110"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <span class="fw-semibold">Kategori Buku</span>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                @if ($bookCategories->isNotEmpty())
                    <canvas id="categoryChart" height="220"></canvas>
                @else
                    <p class="text-muted small mb-0">Belum ada data buku.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Tables --}}
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Transaksi Terbaru</span>
                <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Anggota</th>
                            <th>Buku</th>
                            <th class="pe-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentBorrowings as $borrowing)
                            <tr>
                                <td class="ps-4">{{ $borrowing->member->name }}</td>
                                <td class="text-truncate" style="max-width:150px">{{ $borrowing->book->title }}</td>
                                <td class="pe-4 text-center">
                                    @if ($borrowing->status === 'borrowed')
                                        <span class="badge" style="background:#fffbeb;color:#92400e;">Dipinjam</span>
                                    @else
                                        <span class="badge" style="background:#f0fdf4;color:#166534;">Kembali</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold" style="color:#dc2626;"><i class="bi bi-exclamation-triangle me-1"></i>Terlambat Kembali</span>
                <a href="{{ route('borrowings.index', ['status' => 'borrowed']) }}" class="btn btn-sm btn-outline-danger">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Anggota</th>
                            <th>Buku</th>
                            <th class="pe-4 text-center">Batas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lateBorrowings as $borrowing)
                            <tr>
                                <td class="ps-4">{{ $borrowing->member->name }}</td>
                                <td class="text-truncate" style="max-width:150px">{{ $borrowing->book->title }}</td>
                                <td class="pe-4 text-center fw-semibold text-danger">{{ $borrowing->due_date->format('d/m/Y') }}</td>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.font.size = 12;

    new Chart(document.getElementById('borrowingChart'), {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Peminjaman',
                data: @json($monthTotals),
                backgroundColor: 'rgba(37,99,235,0.12)',
                borderColor: '#2563eb',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,0.04)' } },
                x: { grid: { display: false } }
            }
        }
    });

    @if ($bookCategories->isNotEmpty())
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($bookCategories->pluck('category')),
            datasets: [{
                data: @json($bookCategories->pluck('total')),
                backgroundColor: ['#2563eb','#16a34a','#d97706','#0284c7','#dc2626','#7c3aed'],
                borderWidth: 3,
                borderColor: '#fff',
            }]
        },
        options: {
            cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, padding: 12 } } }
        }
    });
    @endif
</script>
@endpush
