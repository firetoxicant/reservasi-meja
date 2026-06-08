<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Restoran</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; font-size: 12px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 3px double #333; padding-bottom: 10px; }
        .header h2 { margin: 0; padding: 0; uppercase; color: #111; font-size: 20px; }
        .header p { margin: 5px 0 0 0; color: #555; }
        .meta-info { margin-bottom: 15px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { bg-color: #4f46e5; color: white; padding: 8px; font-weight: bold; text-transform: uppercase; font-size: 11px; border: 1px solid #ddd; text-align: left; }
        td { padding: 8px; border: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .total-row { font-weight: bold; background-color: #eaeaea !important; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .text-green { color: #15803d; }
        .text-orange { color: #c2410c; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Transaksi Pendapatan & Reservasi</h2>
        <p>Aplikasi Reservasi Meja & Manajemen Restoran Manajemen</p>
    </div>

    <div class="meta-info">
        Jadwal Rekapitulasi Kurun Waktu Periode: <strong>{{ \Carbon\Carbon::parse($tanggalAwal)->format('d F Y') }}</strong> s.d <strong>{{ \Carbon\Carbon::parse($tanggalAkhir)->format('d F Y') }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%">Tanggal Trx</th>
                <th style="width: 15%">Kode Booking</th>
                <th style="width: 18%">Nama Pelanggan</th>
                <th style="width: 16%">Petugas Kasir</th>
                <th style="width: 12%">Total Awal</th>
                <th style="width: 12%">Uang Muka (DP)</th>
                <th style="width: 12%">Uang Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanData as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i') }}</td>
                <td class="text-bold" style="color: #4f46e5;">{{ $data->reservasi->kode_reservasi ?? '-' }}</td>
                <td>{{ $data->pelanggan->nama_lengkap ?? '-' }}</td>
                <td>
                    {{ $data->id_kasir === $data->id_pelanggan ? 'Self-Service' : ($data->kasir->nama_lengkap ?? '-') }}
                </td>
                <td>Rp {{ number_format($data->total_awal, 0, ',', '.') }}</td>
                <td class="text-orange">Rp {{ number_format($data->dp, 0, ',', '.') }}</td>
                <td class="text-bold text-green">Rp {{ number_format($data->bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL OMZET PERIODE:</td>
                <td>Rp {{ number_format($grandTotalAwal, 0, ',', '.') }}</td>
                <td class="text-orange">Rp {{ number_format($grandTotalDp, 0, ',', '.') }}</td>
                <td class="text-green">Rp {{ number_format($grandTotalBayar, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>