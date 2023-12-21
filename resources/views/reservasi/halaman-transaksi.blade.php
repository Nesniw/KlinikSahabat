@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Pembayaran Layanan</h1>
</div> 
<div class="container">
    <h5 class="text-center text-secondary m-5">Silahkan melanjutkan proses pembayaran layanan</h5>
</div> 
<div class="pembayaranContainer mx-auto">
    <div class="row gx-4">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header text-center"><h5>Detail Transaksi</h5></div>
                <div class="card-body">
                    <ul class="px-3" type="None">
                        <div class="d-flex my-1">
                            <div class="me-auto">Kode Transaksi :</div>
                            <div class="p-2">{{ $transaksi->transaksi_id }}</div>
                        </div>
                        <div class="d-flex my-1">
                            <div class="me-auto">Layanan :</div>
                            <div class="p-2">{{ $transaksi->layanan->nama_layanan }}</div>
                        </div>
                        <div class="d-flex my-1">
                            <div class="me-auto">Nama Pekerja :</div>
                            <div class="p-2">{{ $transaksi->JadwalKlinik->pekerja->namapekerja }}</div>
                        </div>
                        <div class="d-flex my-1">
                            <div class="me-auto">Hari, Tanggal :</div>
                            <div class="p-2">
                                {{ \Carbon\Carbon::parse($transaksi->JadwalKlinik->tanggal)->locale('id')->isoFormat('dddd, DD/MM/YYYY') }}
                            </div>
                        </div>
                        <div class="d-flex my-1">
                            <div class="me-auto">Waktu :</div>
                            <div class="p-2">
                                {{ \Carbon\Carbon::parse($transaksi->JadwalKlinik->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($transaksi->JadwalKlinik->jam_selesai)->addHour()->format('H:i') }}
                            </div>
                        </div>
                        <div class="d-flex my-1">
                            <div class="me-auto">Biaya Booking :</div>
                            <div class="p-2">Rp {{ number_format($transaksi->layanan->biaya_booking, 0, ',', '.') }}</div>
                        </div>
                        <div class="d-flex my-1">
                            <div class="me-auto">Harga Layanan :</div>
                            <div class="p-2">Rp {{ number_format($transaksi->layanan->harga_layanan, 0, ',', '.') }}</div>
                        </div>
                        <div class="d-flex my-1">
                            <div class="me-auto">Total Biaya :</div>
                            <div class="p-2">Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</div>
                        </div>
                        <div class="d-flex my-1">
                            <div class="me-auto">Status :</div>
                            <div class="p-2">{{ $transaksi->status }}</div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card mb-4">
                <div class="card-header text-center"><h5>Batas Pembayaran</h5></div>
                <div class="card-body">
                    <div id="timer"></div>
                    <div class="container text-center">
                        <p class="my-1">Transfer Pembayaran</p>
                        <img src="{{asset('gambar/bca.png')}}" width="130px" height="100px" alt="Gambar Logo BCA">
                        <p>
                            Klinik Sahabat Hewan <br>
                            <b>12345678</b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header text-center"><h5>Konfirmasi Pembayaran</h5></div>
                <div class="card-body">
                    @if ($transaksi->status == 'Menunggu Pembayaran')
                        <form method="POST" action="{{ route ('UploadBuktiTransfer', ['transaksi_id' => $transaksi->transaksi_id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row gx-5 mb-3">
                                <div class="col-md-10">
                                    <label class="small mb-2 text-secondary mx-3" for="bukti_transfer">Upload bukti pembayaran</label>
                                    <input class="form-control mx-3" id="bukti_transfer" name="bukti_transfer" type="file" required>
                                </div>
                            </div>
                            <div class="mx-3 pt-2 my-3">
                                <button class="btn btn-primary" type="submit">Saya sudah transfer</button>
                            </div>
                        </form>
                    @elseif ($transaksi->status == 'Pembayaran Berhasil' || $transaksi->status == 'Selesai')
                        <h6 class="text-center text-success">Pembayaran Anda telah dikonfirmasi</h6>
                    @else  
                        <h6 class="text-center text-danger">Maaf, waktu untuk mengupload bukti pembayaran telah habis</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function startCountdown() {
        var expirationTimestamp = '{{ session('transaksi_expiration_' . $transaksi->transaksi_id) }}';
        var expirationTime = new Date(expirationTimestamp * 1000);

        function updateTimer() {
            var now = new Date();
            var timeLeft = expirationTime - now;

            if (timeLeft < 0) {
                clearInterval(timerInterval);
                document.getElementById("timer").innerHTML = '<div>00<span>Jam</span></div>' +
                    '<div>00<span>Menit</span></div>' +
                    '<div>00<span>Detik</span></div>';
            } else {
                var hours = Math.floor(timeLeft / (1000 * 60 * 60));
                var mins = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                var secs = Math.floor((timeLeft % (1000 * 60)) / 1000);

                document.getElementById("timer").innerHTML =
                    '<div>' + (hours < 10 ? '0' : '') + hours + '<span>Jam</span></div>' +
                    '<div>' + (mins < 10 ? '0' : '') + mins + '<span>Menit</span></div>' +
                    '<div>' + (secs < 10 ? '0' : '') + secs + '<span>Detik</span></div>';
            }
        }

        updateTimer();
        var timerInterval = setInterval(updateTimer, 1000);
    }

    // Panggil fungsi untuk memulai perhitungan mundur
    startCountdown();
</script>

@endsection