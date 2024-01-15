@extends('layouts.master')

@section('content')

    <div class="custom-container px-4 mt-4">
        <div class="alert-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show " role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="row pt-5 gx-5">
            <div class="col-xl-3">
                <!-- Menu card-->
                <div class="card mb-4">
                    <div class="card-header text-danger">Menu Dashboard</div>
                    <div class="card-body">
                        <ul class="px-3" type="None" id="dashboard-menu">
                            <li class="dashboard-menu"><a href="{{ route('editProfile') }}" class=""> Profile</a></li>
                            <li class="dashboard-menu"><a href="{{ route('viewPets') }}" class=""> My Pets</a></li>
                            <li class="dashboard-menu"><a href="{{ route('ViewTransaksi') }}" class="active"> My Transaksi</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Logout card-->
                <div class="card mb-4">
                    <div class="card-header text-danger">Keluar dari Akun saat ini</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-9"> 
                <nav class="nav nav-borders">
                    <a class="nav-link ms-0" href="{{route('DetailMyTransaksi', $transaksi->transaksi_id)}}">Informasi Transaksi</a>
                    <a class="nav-link active" href="{{route('DetailPembayaran', $transaksi->transaksi_id)}}">Informasi Pembayaran</a>
                    @if ($transaksi->Layanan->kategori_layanan === "Pet Clinic")
                        <a class="nav-link" href="{{route('DetailRekamMedis', $transaksi->transaksi_id)}}">Informasi Rekam Medis</a>
                    @endif
                </nav>
                <div class="row gx-3 my-3">
                    <div class="col-md-12">
                        <div class="card mb-4 shadow">
                            <div class="card-body">
                                <h5 class="m-2">Informasi Pembayaran</h5>
                                <hr>
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td style="width: 200px; color: gray;">Tanggal Reservasi</td>
                                            <td style="width: 50px;">:</td>
                                            <td>{{ $transaksi->created_at->format('d/m/Y (H:i:s)') }} WIB</td>
                                        </tr>
                                        <tr>
                                            <td style="color: gray;">Status Pembayaran</td>
                                            <td>:</td>
                                            <td>{{ $transaksi->status }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: gray;">Ekspirasi Pembayaran</td>
                                            <td>:</td>
                                            <td>{{ $transaksi->waktu_ekspirasi }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: gray;">Total Pembayaran</td>
                                            <td>:</td>
                                            <td>Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: gray;">Bukti Pembayaran</td>
                                            <td>:</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-borderless mb-4 gambarBukti">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/'.$transaksi->bukti_transfer) }}" alt="Foto Pekerja" width="350px" height="360px">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!--Bootstrap Script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kGQDBBC11VcCY5u3b5CeZGxWUcXRDFVN+w4dd5Sh0a6RSg9l/5MdeZrOMbP" crossorigin="anonymous"></script>

    <!-- Skrip untuk menampilkan modal -->
    <script>
        $(document).ready(function () {
            // Event click pada tombol Delete untuk menampilkan modal
            $('.btn-delete').click(function () {
                // Dapatkan data-target dari tombol Delete yang diklik
                var targetModalId = $(this).data('target');
                // Tampilkan modal yang sesuai dengan data-target
                $(targetModalId).modal('show');
            });
        });
    </script>

    <!-- Script untuk matiin auto dan manual alert -->
    <script>
        $(document).ready(function() {
            // Close alert after 10 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 10000);

            // Close alert when close button is clicked
            $('.alert .btn-close').on('click', function() {
                $(this).closest('.alert').fadeOut();
            });
        });
    </script>

@endsection