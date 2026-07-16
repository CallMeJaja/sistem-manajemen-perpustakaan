<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Rekapitulasi_{{ now()->format('Ymd_His') }} - GramediKu</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            color: #000;
            margin: 20px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .kop-surat h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .kop-surat h2 { margin: 5px 0; font-size: 16px; font-weight: normal; }
        .kop-surat p { margin: 2px 0; font-size: 13px; }
        
        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 8px; 
            text-align: left; 
            vertical-align: top;
        }
        th { 
            background-color: #f4f4f4; 
            font-weight: bold;
            text-align: center;
        }
        td.text-center { text-align: center; }
        td.text-right { text-align: right; }
        
        /* Trik cetak multi-halaman */
        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
        
        .summary {
            width: 300px;
            float: right;
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 40px;
        }
        .summary p { margin: 5px 0; font-weight: bold; }
        
        .signature-area {
            clear: both;
            width: 300px; 
            float: right; 
            text-align: center;
            margin-top: 20px;
        }
        .signature-area p { margin: 5px 0; }
        
        @media print {
            @page { size: A4 landscape; margin: 0; }
            .no-print { display: none !important; }
            body { margin: 0; padding: 15mm; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #f1f5f9; padding: 15px; margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 24px; cursor: pointer; background: #2563eb; color: white; border: none; border-radius: 6px; font-weight: bold;">Cetak Laporan</button>
        <button onclick="window.close()" style="padding: 10px 24px; cursor: pointer; background: #64748b; color: white; border: none; border-radius: 6px; font-weight: bold; margin-left: 10px;">Tutup</button>
        <p style="margin-top: 10px; font-size: 13px; color: #666;">Gunakan mode Landscape pada dialog cetak (jika tidak otomatis).</p>
    </div>

    <div class="kop-surat">
        <h1>GramediKu</h1>
        <h2>Library Management System</h2>
        <p>Jl. Ipik Gandamanah, Purwakarta</p>
        <p>Email: admin@gramediku.com</p>
    </div>
    
    <div class="report-title">
        Laporan Rekapitulasi Riwayat Transaksi Perpustakaan<br>
        <span style="font-size: 12px; font-weight: normal; text-transform: none;">Periode: Seluruh Data Arsip (Selesai & Ditolak)</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">No. Transaksi</th>
                <th style="width: 20%;">Nama Peminjam</th>
                <th style="width: 20%;">Judul Buku</th>
                <th style="width: 10%;">Tgl Pinjam</th>
                <th style="width: 10%;">Tgl Kembali</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $totalDenda = 0; @endphp
            @forelse ($borrowings as $index => $borrowing)
                @php 
                    if ($borrowing->status === 'returned' && $borrowing->return) {
                        $totalDenda += $borrowing->return->fine_amount;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $borrowing->borrow_number }}</td>
                    <td>{{ $borrowing->member->name }}<br><small style="color: #666;">ID: {{ $borrowing->member->member_number }}</small></td>
                    <td>{{ $borrowing->book->title }}</td>
                    <td class="text-center">{{ $borrowing->borrow_date ? $borrowing->borrow_date->translatedFormat('d/m/Y') : '-' }}</td>
                    <td class="text-center">
                        @if ($borrowing->status === 'returned' && $borrowing->return)
                            {{ \Carbon\Carbon::parse($borrowing->return->return_date)->translatedFormat('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($borrowing->status === 'returned')
                            Selesai
                        @elseif ($borrowing->status === 'cancelled')
                            Dibatalkan
                        @else
                            Ditolak
                        @endif
                    </td>
                    <td class="text-right">
                        @if ($borrowing->status === 'returned' && $borrowing->return)
                            Rp {{ number_format($borrowing->return->fine_amount, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">Belum ada data riwayat transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if ($borrowings->count() > 0)
    <div class="summary">
        <p style="display: flex; justify-content: space-between;">
            <span>Total Transaksi:</span> 
            <span>{{ $borrowings->count() }}</span>
        </p>
        <p style="display: flex; justify-content: space-between;">
            <span>Total Denda Terkumpul:</span> 
            <span>Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
        </p>
    </div>
    @endif
    
    <div class="signature-area">
        <p>Purwakarta, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Administrator,</p>
        <br><br><br><br>
        <p><strong>( ________________________ )</strong></p>
    </div>

    <script>
        // Opsional: otomatis memunculkan print dialog saat dibuka
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>