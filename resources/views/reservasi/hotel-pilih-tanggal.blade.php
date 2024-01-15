@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Reservasi Pet Hotel</h1>
</div> 

<div class="container pt-5">
    <h5>
        <a class="linky" href="/">Home</a> / 
        <a class="linky" href="{{route('LayananPage')}}">Layanan</a> / 
        <a class="linky activated" href="{{route('ReservasiPetHotel')}}">Reservasi Pet Hotel</a>
    </h5>

    <div class="container mt-3">
        <div class="alert-container">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show " role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="container my-5">
        <div class="card mb-4">
            <!-- Bisa diisi mx-auto -->
            <div class="card-body">
                <form method="post" action="{{route('ProsesJadwalPetHotel')}}">
                    @csrf

                    <!-- Tanggal Reservasi -->
                    <div class="row gx-3 mt-2 mb-4">
                        <div class="col-md-12 text-center my-auto">
                            <h4>Lengkapi Data Reservasi</h4>
                        </div>
                    </div>
                    
                    <div class="row gx-3 mb-5 justify-content-center">
                        <div class="col-md-3 text-center my-auto"> 
                            <label class="medium mb-1" for="tanggal">Tanggal Menginap <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-3 text-center"> 
                            <input type="date" class="form-control" id="tanggalInap" name="tanggal" 
                                min="{{ now()->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Lama Menginap -->
                    <div class="row gx-3 mb-5 justify-content-center">
                        <div class="col-md-3 text-center my-auto"> 
                            <label class="medium mb-1" for="tanggal">Lama Menginap <span class="text-danger">*</span> <br>(Dalam satuan hari) </label>
                        </div>
                        <div class="col-md-3 text-center"> 
                            <input class="form-control" id="lama_tinggal" name="lama_tinggal" type="number" placeholder="Masukkan Lama Menginap"  value="" min="1" max="364" required>
                        </div>
                    </div>

                    <!-- Waktu Menginap / Waktu Check In -->
                    <div class="row gx-3 mb-5 justify-content-center">
                        <div class="col-md-3 text-center my-auto"> 
                            <label class="medium mb-1" for="waktu">Waktu Check In <span class="text-danger">*</span> </label><br>
                            <label class="small text-danger">(09:00 - 16:00)</label>
                        </div>
                        <div class="col-md-3 text-center "> 
                            <input class="form-control" id="waktu" name="waktu" type="time" value="" min="09:00" max="17:00" required>
                        </div>
                    </div>

                    <!-- Catatan Untuk Pengelola Pet Hotel -->
                    <div class="row gx-3 mb-5 justify-content-center">
                        <div class="col-md-3 my-auto"> 
                            <label class="medium mb-1" for="catatan">Catatan / Keterangan Khusus </label>
                        </div>
                        <div class="col-md-3 my-auto"> 
                            <textarea class="form-control catatan" rows="4" cols="50" id="catatan" name="catatan"></textarea>
                        </div>
                    </div>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-12 text-center my-auto"> 
                            <button type="submit" class="btn btn-primary">Lanjut</button>
                        </div>
                    </div>
                </form>

                <!-- Optional: Add a Bootstrap modal for confirmation -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to leave? Your data will be lost.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="confirmLeaveButton">Leave</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Menangkap elemen formulir
        var form = document.querySelector('form');

        // Menangkap elemen input tanggal, lama_tinggal, waktu, dan catatan
        var tanggalInput = document.getElementById('tanggalInap');
        var waktuInput = document.getElementById('waktu');

        // Menambahkan event listener pada pengiriman formulir
        form.addEventListener('submit', function (event) {
            // Mendapatkan nilai tanggal dan waktu yang dipilih
            var selectedDate = new Date(tanggalInput.value);
            var selectedTime = new Date('1970-01-01T' + waktuInput.value);

            // Mendapatkan waktu sekarang
            var now = new Date();

            // Menggabungkan tanggal dan waktu yang dipilih
            var selectedDateTime = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), selectedTime.getHours(), selectedTime.getMinutes());

            // Pengecekan apakah tanggal sama dengan hari ini dan waktu melewati waktu sekarang
            if (selectedDate.toDateString() === now.toDateString() && selectedDateTime <= now) {
                // Menghentikan pengiriman formulir
                event.preventDefault();

                // Menampilkan pesan kesalahan
                alert('Tidak bisa check-in untuk waktu yang telah lewat. Pilih waktu check-in yang sesuai!');
            }
        });
    });
</script>

@endsection