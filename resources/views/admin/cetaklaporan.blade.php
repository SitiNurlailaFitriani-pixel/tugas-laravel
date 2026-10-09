<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Transaksi Harian - GRIDAS BANK</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            margin: 20px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .header h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 4px 0 0 0;
            font-size: 12pt;
            color: #444;
        }

        .info-cetak {
            margin-bottom: 12px;
            font-size: 9.5pt;
            display: flex;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }

        td {
            padding: 7px 9px;
            vertical-align: middle;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }

        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>GRIDAS BANK</h2>
        <h3>LAPORAN TRANSAKSI HARIAN</h3>
        <p style="margin: 5px 0 0 0; font-size: 10pt;">
            Tanggal Laporan: <strong>{{ !empty($tanggalInput) ? \Carbon\Carbon::parse($tanggalInput)->translatedFormat('d F Y') : 'Semua Tanggal' }}</strong>
        </p>
    </div>

    <div class="info-cetak">
        <div><strong>Waktu Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</div>
        <div><strong>Total Transaksi:</strong> {{ $transaksi->count() }} Data</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="20%">Waktu Transaksi</th>
                <th width="20%">No. Rekening</th>
                <th width="22%">Nama Nasabah</th>
                <th width="15%">Jenis Transaksi</th>
                <th width="18%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y, H:i') }}</td>
                    
                    <td class="text-center fw-bold">
                        {{ $item->no_rekening ?? '-' }}
                    </td>
                    
                    <td>
                        {{ $item->username ?? '-' }}
                    </td>
                    
                    <td class="text-center">
                        {{ $item->jenis_transaksi ?? 'Setor Tunai' }}
                    </td>
                    
                    <td class="text-right fw-bold">
                        Rp {{ number_format($item->nominal ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 15px;">
                        Tidak ada transaksi {{ !empty($tanggalInput) ? 'pada tanggal ' . \Carbon\Carbon::parse($tanggalInput)->translatedFormat('d F Y') : '' }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($transaksi->count() > 0)
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL NOMINAL:</th>
                <th class="text-right">
                    Rp {{ number_format($totalNominal ?? $transaksi->sum('nominal'), 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
        @endif
    </table>

</body>
</html>