<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Peminjaman - {{ $borrowing->borrow_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            margin: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
        }

        .info {
            margin-bottom: 15px;
        }

        .info table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 3px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            border-top: 1px dashed #ccc;
            pt: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="background: #f4f4f4; padding: 10px; margin-bottom: 20px; border-radius: 5px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #2563eb; color: white; border: none; border-radius: 4px;">Cetak Sekarang</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; background: #64748b; color: white; border: none; border-radius: 4px;">Tutup</button>
    </div>

    <div class="header">
        <h2>Perpustakaan Digital</h2>
        <p>Struk Bukti {{ $borrowing->status === 'returned' ? 'Pengembalian' : 'Peminjaman' }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td style="width: 130px;">No. Transaksi</td>
                <td>: {{ $borrowing->borrow_number }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ now()->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr style="border: 0; border-top: 1px dashed #ccc;">
                </td>
            </tr>
            <tr>
                <td>Nama Anggota</td>
                <td>: {{ $borrowing->member->name }}</td>
            </tr>
            <tr>
                <td>ID Anggota</td>
                <td>: {{ $borrowing->member->member_number }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr style="border: 0; border-top: 1px dashed #ccc;">
                </td>
            </tr>
            <tr>
                <td valign="top">Judul Buku</td>
                <td>: {{ $borrowing->book->title }}</td>
            </tr>
            <tr>
                <td>Tgl Pinjam</td>
                <td>: {{ $borrowing->borrow_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>{{ $borrowing->status === 'returned' ? 'Tgl Kembali' : 'Batas Kembali' }}</td>
                <td>: {{ $borrowing->status === 'returned' ? $borrowing->return->return_date->format('d/m/Y') : $borrowing->due_date->format('d/m/Y') }}</td>
            </tr>
            @if ($borrowing->status === 'returned' && $borrowing->return->fine_amount > 0)
            <tr>
                <td>Denda</td>
                <td>: Rp {{ number_format($borrowing->return->fine_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="footer">
        <p>Terima kasih telah berkunjung.<br>Harap jaga buku dengan baik.</p>
        <small>Simpan struk ini sebagai bukti transaksi.</small>
    </div>

    <script>
        window.onload = function() {
            // Uncomment line below if you want it to trigger print immediately
            // window.print();
        };
    </script>
</body>

</html>