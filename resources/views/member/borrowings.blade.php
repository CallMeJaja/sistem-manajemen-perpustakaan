@extends('layouts.member')

@section('title', 'Pinjaman Saya — Member Portal')

@section('content')
<h4 class="fw-bold mb-3">Riwayat Pinjaman Saya</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('member.borrowings') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <label for="status" class="form-label fw-medium mb-0">Status</label>
                <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                    <option value="borrowed" @selected(request('status') === 'borrowed')>Sedang Dipinjam</option>
                    <option value="returned" @selected(request('status') === 'returned')>Dikembalikan</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Dibatalkan</option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Denda</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrowings as $b)
                        @php
                            $map = [
                                'pending'  => ['Menunggu', 'bg-info-subtle text-info-emphasis'],
                                'borrowed' => ['Dipinjam', 'bg-warning-subtle text-warning-emphasis'],
                                'returned' => ['Kembali', 'bg-success-subtle text-success-emphasis'],
                                'rejected' => ['Ditolak', 'bg-danger-subtle text-danger-emphasis'],
                                'cancelled' => ['Dibatalkan', 'bg-secondary-subtle text-secondary-emphasis'],
                            ];
                            [$lbl, $cls] = $map[$b->status] ?? [ucfirst($b->status), 'bg-secondary-subtle'];
                        @endphp
                        <tr>
                            <td class="small fw-semibold">{{ $b->borrow_number }}</td>
                            <td>{{ $b->book->title }}</td>
                            <td class="small text-muted">{{ $b->borrow_date ? $b->borrow_date->translatedFormat('d/m/Y') : '-' }}</td>
                            <td class="small">{{ $b->due_date ? $b->due_date->translatedFormat('d/m/Y') : '-' }}</td>
                            <td class="text-center"><span class="badge {{ $cls }}">{{ $lbl }}</span>
                                @if ($b->status === 'rejected' && $b->rejection_reason)
                                    <br><small class="text-muted d-block mt-1">Alasan: {{ $b->rejection_reason }}</small>
                                @endif
                            </td>
                            <td class="text-center small">
                                @if ($b->return && $b->return->fine_amount > 0)
                                    <span class="text-danger">Rp {{ number_format($b->return->fine_amount, 0, ',', '.') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($b->status === 'pending')
                                    <form method="POST" action="{{ route('member.borrowings.cancel', $b) }}"
                                          onsubmit="return confirm('Batalkan reservasi ini?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger">Batalkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-empty-state icon="bi-journal-x" message="Belum ada pinjaman." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination-wrap :paginator="$borrowings" />
    </div>
</div>
@endsection
