@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-center mt-5 mx-4 mb-4">
        <h2 class=" mb-0 text-gray-600">Cetak Laporan Transaksi - Klinik Sahabat Hewan</h2>
    </div>

    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    
    <div class="mt-4 mx-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" id="cetakForm" >
                            @csrf
                            <div class="row gx-3 mb-4">
                                <div class="col-md-6 my-auto"> 
                                    <label class="medium mb-1" for="layanan_id">Pilih Transaksi :</label>
                                    <select class="form-select form-control" id="layanan_id" name="layanan_id" required>
                                        <option value="all" selected>Semua Transaksi</option>
                                        <option value="Pet Clinic">Transaksi Pet Clinic</option>
                                        <option value="Pet Grooming">Transaksi Pet Grooming</option>
                                        <option value="Pet Hotel">Transaksi Pet Hotel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-3 mb-5">
                                <div class="col-md-6 my-auto"> 
                                    <label class="medium mb-1" for="start_date">Tanggal Mulai :</label>
                                    <input class="form-control" type="date" name="start_date" required>
                                </div>
                                <div class="col-md-6 my-auto"> 
                                    <label class="medium mb-1" for="end_date">Tanggal Akhir :</label>
                                    <input class="form-control" type="date" name="end_date" required>
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-md-12 text-center my-auto"> 
                                    <button type="submit" name="action" value="lihat" class="btn btn-success me-5">Lihat Laporan Transaksi</button>
                                    <button type="submit" name="action" value="cetak" class="btn btn-primary">Cetak Laporan Transaksi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menangani perubahan action formulir berdasarkan tombol yang ditekan
        document.getElementById('cetakForm').addEventListener('submit', function(e) {
            var actionButton = document.activeElement;

            // Periksa tombol yang ditekan
            if (actionButton && actionButton.tagName === 'BUTTON') {
                var actionValue = actionButton.getAttribute('value');

                // Ubah action formulir berdasarkan nilai tombol
                if (actionValue === 'cetak') {
                    this.action = "{{ route('cetak_laporan') }}";
                } else if (actionValue === 'lihat') {
                    this.target = '_blank';
                    this.action = "{{ route('view_laporan') }}"; // Ganti dengan route yang sesuai
                }
            }
        });
    </script>

@endsection