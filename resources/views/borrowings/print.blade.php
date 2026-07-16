<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Peminjaman - {{ $borrowing->borrow_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
            max-width: 520px;
            margin: 20px auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header-left h2 {
            margin: 0 0 3px 0;
            font-size: 15px;
            font-weight: bold;
        }
        .header-left p {
            margin: 1px 0;
            font-size: 11px;
        }
        .header-right {
            text-align: right;
            font-size: 11px;
        }
        .header-right .receipt-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 4px;
        }
        .info table {
            width: 100%;
            border-collapse: collapse;
        }
        .info td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 12px;
        }
        .info td:first-child {
            width: 130px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .section-title {
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            text-align: center;
            margin-top: 25px;
        }
        .signatures div {
            width: 45%;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            border-top: 2px dashed #000;
            padding-top: 8px;
            font-size: 10px;
        }
        @media print {
            .no-print { display: none !important; }
            @page { size: A4 portrait; margin: 0; }
            body { margin: 0; padding: 20mm; max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #f1f5f9; padding: 15px; margin-bottom: 20px; border-radius: 8px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 24px; cursor: pointer; background: #2563eb; color: white; border: none; border-radius: 6px; font-weight: bold;">Cetak Struk</button>
        <button onclick="window.close()" style="padding: 10px 24px; cursor: pointer; background: #64748b; color: white; border: none; border-radius: 6px; font-weight: bold; margin-left: 10px;">Tutup</button>
    </div>

    <div class="header">
        <div class="header-left">
            <h2>GramediKu</h2>
            <p>Library Management System</p>
            <p>Jl. Ipik Gandamanah, Purwakarta</p>
            <p>admin@gramediku.com</p>
        </div>
        <div class="header-right">
            <div class="receipt-title">BUKTI {{ strtoupper($borrowing->status === 'returned' ? 'Pengembalian' : 'Peminjaman') }}</div>
            <div>{{ $borrowing->borrow_number }}</div>
            <div>{{ now()->translatedFormat('d M Y, H:i') }}</div>
        </div>
    </div>

    <div style="text-align: center; margin-bottom: 15px;">
        <img src="https://quickchart.io/qr?text={{ urlencode($borrowing->borrow_number) }}&size=100" alt="QR Code" style="width: 100px; height: 100px;">
        <div style="font-size: 9px; color: #666; margin-top: 3px;">Scan untuk pencarian cepat</div>
    </div>

    <div class="info">
        <div class="section-title">Data Anggota</div>
        <table>
            <tr>
                <td>No. Anggota</td>
                <td>: {{ $borrowing->member->member_number }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: {{ $borrowing->member->name }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="section-title">Data Buku</div>
        <table>
            <tr>
                <td>Judul</td>
                <td>: {{ $borrowing->book->title }}</td>
            </tr>
            <tr>
                <td>Penulis</td>
                <td>: {{ $borrowing->book->author }}</td>
            </tr>
            <tr>
                <td>Nomor Rak</td>
                <td>: {{ $borrowing->book->location ?? '-' }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="section-title">Detail Transaksi</div>
        <table>
            <tr>
                <td>Tgl. Pinjam</td>
                <td>: {{ $borrowing->borrow_date ? $borrowing->borrow_date->translatedFormat('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Jatuh Tempo</td>
                <td>: {{ $borrowing->due_date ? $borrowing->due_date->translatedFormat('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ strtoupper($borrowing->status) }}</td>
            </tr>
            @if ($borrowing->status === 'returned' && $borrowing->return)
            <tr>
                <td>Tgl. Kembali</td>
                <td>: {{ \Carbon\Carbon::parse($borrowing->return->return_date)->translatedFormat('d M Y') }}</td>
            </tr>
            @if ($borrowing->return->fine_amount > 0)
            <tr>
                <td>Denda</td>
                <td>: <strong>Rp {{ number_format($borrowing->return->fine_amount, 0, ',', '.') }}</strong></td>
            </tr>
            @endif
            @endif
        </table>
    </div>

    @if ($borrowing->status === 'borrowed' || $borrowing->status === 'pending')
    <div style="margin-top: 12px; font-size: 10px; text-align: justify;">
        Harap mengembalikan buku tepat waktu. Keterlambatan dikenakan denda Rp 1.000/hari.
    </div>
    @endif

    <div class="signatures">
        <div>
            <p>Peminjam,</p>
            <br><br><br>
            <p>( {{ $borrowing->member->name }} )</p>
        </div>
        <div>
            <p>Petugas,</p>
            <br><br><br>
            <p>( Administrator )</p>
        </div>
    </div>

    <div class="footer">
        Simpan struk ini sebagai bukti transaksi.<br>
        Terima kasih atas kunjungan Anda.
    </div>
</body>
</html>