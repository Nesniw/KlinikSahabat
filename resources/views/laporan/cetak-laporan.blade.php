<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>

    <!-- CSS bootstrap yang dipake -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <style>
        /* Gaya CSS untuk tampilan PDF */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2, h4 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        .gray {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi Klinik Sahabat Hewan</h2>
    <h4>Jenis Laporan: {{ $data['jenis_laporan'] }}</h4>
    <h4>{{ $data['periode'] }}</h4>
    
    <table>
        <thead>
            <tr> 
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Layanan</th>
                <th>Customer</th>
                <th>Waktu</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @if($transaksi->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">Tidak terdapat transaksi</td>
                </tr>
            @else
                @foreach($transaksi as $key => $transaction)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $transaction->transaksi_id }}</td>
                        <td>{{ $transaction->layanan->nama_layanan }}</td>
                        <td>{{ $transaction->user->namalengkap }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->tanggal)->isoFormat('DD/MM/YYYY') }} ({{ \Carbon\Carbon::parse($transaction->waktu)->format('H:i') }} WIB)</td>
                        <td>Rp {{ number_format($transaction->total_biaya, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right gray"><b>Total Pendapatan :</b></td>
                    <td class="gray">Rp {{ number_format($data['totalIncome'], 2, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>