@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Reservasi Pet Grooming</h1>
</div> 

<div class="container pt-5">
    <h5 class="Centering">
        <a class="linky" href="/">Home</a> / 
        <a class="linky" href="{{route('LayananPage')}}">Layanan</a> / 
        <a class="linky activated" href="{{route('ReservasiPetGrooming')}}">Reservasi Pet Grooming</a>
    </h5>

    <div class="container my-5">
        <div class="card mb-4">
            <!-- Bisa diisi mx-auto -->
            <div class="card-body">
                <form method="post" action="{{route('ProsesJadwalPetGrooming')}}">
                    @csrf

                    <!-- Tanggal Reservasi -->
                    <div class="row gx-3 mt-3 mb-5">
                        <div class="col-md-12 text-center my-auto">
                            <h4>Lengkapi Data Reservasi</h4>
                        </div>
                    </div>
                    <div class="row gx-3 mb-5 justify-content-center">
                        <div class="col-md-3 text-center my-auto"> 
                            <label class="medium mb-1" for="tanggal">Pilih Tanggal Grooming <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-3 text-center"> 
                            <input type="date" class="form-control" id="tanggalGrooming" name="tanggal" 
                                    min="{{ now()->format('Y-m-d') }}"
                                    max="{{ now()->addDays(7)->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Waktu Grooming  -->
                    <div class="row gx-3 mb-5 justify-content-center">
                        <div class="col-md-3 text-center my-auto"> 
                            <label class="medium mb-1" for="waktu">Waktu Grooming <span class="text-danger">*</span> </label><br>
                            <label class="small text-danger">(09:00 - 16:00)</label>
                        </div>
                        <div class="col-md-3 text-center"> 
                            <input class="form-control " id="waktu" name="waktu" type="time" value="" min="09:00" max="16:00" placeholder="hour" required><br>
                            <label class="small text-danger">Estimasi selesai untuk setiap grooming adalah 1-3 jam dari waktu grooming</label>
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
        var tanggalInput = document.getElementById('tanggalGrooming');
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
                alert('Tidak bisa reservasi untuk waktu yang telah lewat. Pilih waktu yang sesuai!');
            }
        });
    });
</script>


@endsection