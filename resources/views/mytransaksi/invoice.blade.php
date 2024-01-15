<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>

    <link href="css/stylePDF.css" rel="stylesheet">
    <style>

        h4 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 5px solid #000;
        }

        th {
            background-color: #f2f2f2;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        td{
            padding-top: 20px;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="pdf-container">
        <div class="row">
            <div class="column left">
                <h1>INVOICE</h1>
                <h2>Klinik Sahabat Hewan</h2>
            </div>
            <div class="column right">
                <img class="margin-top margin-right" src="gambar/Logo Klinik Sahabat Hewan Clear.png" width="100px" height="100px" alt="">
            </div>
        </div>
        
        <p><b>Nama Customer : </b> {{ $transaksi->user->namalengkap }} </p>
        <p><b>Tanggal : </b> {{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->isoFormat('dddd, DD/MM/YYYY') }}</p>
        
        <table>
            <thead>
                <tr> 
                    <th>LAYANAN</th>
                    <th>HARGA</th>
                    <th>BIAYA BOOKING</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $transaksi->layanan->nama_layanan }}</td>
                    <td>Rp {{ number_format($transaksi->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->layanan->biaya_booking, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <h3 class="align-right"><b>TOTAL : </b> Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }} </h3>
        <h3 class="margin-top3"><b>PEMBAYARAN : </b></h3>
        <p>Rekening BCA : Klinik Sahabat Hewan</p>
        <p>No. Rekening : 12345678</p>
        <h1 class="margin-top3 center">TERIMA KASIH</h1>
    </div>
    
</body>
</html>