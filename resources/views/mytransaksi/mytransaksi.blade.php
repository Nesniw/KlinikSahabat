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
                <div class="card mb-4">
                    <div class="card-header"><h5>My Transaksi</h5></div>
                    <div class="card-body">
                        <form method="get" action="{{ route('ViewTransaksi') }}">
                            <div class="row gx-3 mb-3 d-flex justify-content-around">
                                <div class="col-8 col-lg-4 col-md-5 col-sm-7">
                                    <div class="mb-3">
                                        <label for="statusFilter" class="form-label text-danger">Filter berdasarkan status:</label>
                                        <select class="form-select p-3 pe-5" name="statusFilter" id="statusFilter" onchange="this.form.submit()">
                                            <option value="" selected>Semua Status</option>
                                            @foreach(['Menunggu Pembayaran', 'Pembayaran Gagal', 'Pembayaran Berhasil', 'Proses Grooming Selesai', 'Selesai', 'Expired'] as $status)
                                                <option value="{{ $status }}" {{ request('statusFilter') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 col-lg-3 col-md-3">
                                    <div class="mb-3">
                                        <label for="dateFilter" class="form-label text-danger">Filter berdasarkan tanggal:</label>
                                        <input type="date" class="form-control" name="dateFilter" id="dateFilter" value="{{ request('dateFilter') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                                <div class="col-4 col-8 col-lg-3 col-md-4 col-sm-12 my-auto">
                                    <form method="GET" action="{{ route('LayananPage') }}">
                                        @csrf
                                        <button class="btn btn-warning btnHUHA" type="submit">Reservasi Layanan<i class="fa-solid fa-plus"></i></button>
                                    </form>
                                </div>
                            </div>
                        </form>
                        <hr class="mt-4 mb-5">
                        @forelse ($userTransaction as $transaksi)
                            <div class="row mx-2 gx-4 gy-3 mb-5 shadowBox rounded">
                                <div class="col-md-5">
                                    <div class="container">{{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->isoFormat('DD-MM-YYYY') }}</div>
                                    <h2 class="text-warning text-center mt-5">{{ $transaksi->transaksi_id }}</h2>
                                    <div class="container text-center d-flex justify-content-center align-items-center">
                                        @if ($transaksi->status === "Menunggu Pembayaran" || $transaksi->status === "Pembayaran Gagal")
                                        <a href="{{route('ShowHalamanPembayaran', $transaksi->transaksi_id)}}" class="btn btn-success mt-5">Bayar</a>
                                        @else
                                        <a href="{{route('DetailMyTransaksi', $transaksi->transaksi_id)}}" class="btn btn-primary mt-5">Detail</a>
                                        @endif

                                        @if ($transaksi->status === "Pembayaran Berhasil" || $transaksi->status === "Selesai")
                                        <form id="invoiceForm" action="{{ route('ViewInvoice', $transaksi->transaksi_id) }}" method="post">
                                            @csrf
                                            <button class="btn btn-warning ms-3 mt-5" type="button" onclick="submitFormWithTargetBlank()">Invoice</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h4 class="text-warning text-center">{{ $transaksi->pets->namapasien }}</h4>
                                    <div class="hr-theme-slash-2">
                                        <div class="hr-line"></div>
                                        <div class="hr-icon"><i class="material-icons">pets</i></div>
                                        <div class="hr-line"></div>
                                    </div>
                                    <table class="table mb-4">
                                        <tbody>
                                            <tr>
                                                <td>Kategori</td>
                                                <td >{{ $transaksi->Layanan->kategori_layanan }}</td>
                                            </tr>
                                            <tr>
                                                <td>Layanan</td>
                                                <td>{{ $transaksi->Layanan->nama_layanan }}</td>
                                            </tr>
                                            @if ($transaksi->Layanan->kategori_layanan === "Pet Clinic")
                                                <tr>
                                                    <td>Jadwal Layanan</td>
                                                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->isoFormat('DD-MM-YYYY') }} | ({{ $transaksi->JadwalKlinik->jam_mulai }} - {{ $transaksi->JadwalKlinik->jam_selesai }} WIB)</td>
                                                </tr>
                                            @elseif ($transaksi->Layanan->kategori_layanan === "Pet Grooming")
                                                <tr>
                                                    <td>Waktu Grooming</td>
                                                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->isoFormat('DD-MM-YYYY') }} | ({{ \Carbon\Carbon::parse($transaksi->waktu)->format('H:i') }} WIB)</td>
                                                </tr>
                                            @elseif ($transaksi->Layanan->kategori_layanan === "Pet Hotel")
                                                <tr>
                                                    <td>Waktu Check-In</td>
                                                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->isoFormat('DD-MM-YYYY') }} | ({{ \Carbon\Carbon::parse($transaksi->waktu)->format('H:i') }} WIB)</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Status</td>
                                                <td>{{ $transaksi->status }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-4 mb-3"></div>
                        @empty
                            <h5 class="text-center text-danger mt-5">Transaksi tidak ditemukan.</h5>
                        @endforelse
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

    <script>
        function submitFormWithTargetBlank() {
            var form = event.target.closest('form');
            form.target = '_blank';
            form.submit();
        }
    </script>

@endsection