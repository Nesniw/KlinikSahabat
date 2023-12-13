<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Klinik Sahabat Hewan</title>
    <link rel="shortcut icon" href="{{ asset('gambar/Logo Klinik Sahabat Hewan Clear.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&family=Roboto:wght@500&family=Salsa&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="navBar-container sticky-top" id="navbar">
        <div class="row align-items-center">
            <div class="col-2 klinik-title">
                Klinik <span>Sahabat</span><br> Hewan 
            </div>
            <div class="col-1">
                <img src="/gambar/Logo Klinik Sahabat Hewan.png" width="70px" height="70px" alt=""></span>
            </div>
            <div class="col-7">
                <ul class="nav justify-content-center" type="None">
                    <li class="nav-list">
                        <a class="navLinks" href="/">Beranda</a>
                    </li>
                    <li class="nav-list">
                        <a class="navLinks" href="/layanan">Layanan</a>
                    </li>
                    <li class="nav-list">
                        <a class="navLinks" href="/about">Tentang</a>
                    </li>
                    <li class="nav-list">
                        <a class="navLinks" href="/contactus">Hubungi Kami</a>
                    </li>
                </ul>
                <!-- <ul class="nav nav-tabs justify-content-center" id="main-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hubungi Kami</a>
                    </li>
                </ul> -->
            </div>
            <div class="col-2">
                @if(Route::has('login'))
                    @auth

                    {{-- Admin, Dokter, Groomer login Dashboard--}}
                    @if(in_array(Auth::user()->roles, ['Admin', 'Dokter', 'Groomer']))
                    <ul class="nav justify-content-center" type="None">
                        <li class="nav-lists">
                            <a aria-label="my account" href="{{ route('editProfile') }}" class="">
                                <img class="imgLogo" src="gambar/Red Prof.png" width="40px" height="40px" alt="account"><br>
                            </a>
                            <label class="linkLabel">My Account</label>
                        </li>
                        <li class="nav-lists">
                            <a aria-label="my dashboard" href="{{ route('adminDashboard') }}" class="">
                                <img class="imgLogo" src="gambar/Dashb.png" width="40px" height="40px" alt="dashboard"><br>
                                <label class="linkLabel">My Dashboard</label>
                            </a>
                        </li>
                    </ul>
                    @endif

                    {{-- Customer login Dashboard--}}
                    @if(Auth::user()->roles == 'Customer')
                    <ul class="nav justify-content-center" type="None">
                        <li class="nav-lists">
                            <a aria-label="my dashboard" href="{{ route('editProfile') }}" class="">
                                <img class="imgLogo" src="gambar/Dashb.png" width="40px" height="40px" alt="dashboard"><br>
                            </a>
                            <label class="linkLabel">My Dashboard</label>
                        </li>
                    </ul>
                    @endif

                @else
                    <a class="btnLink" href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endauth
                @endif
            </div>
        </div>
    </div>
    <div class="custom-container px-4 mt-4">
        
        <div class="row pt-5 gx-5">
            <div class="col-xl-3">
                <!-- Menu card-->
                <div class="card mb-4">
                    <div class="card-header text-danger">Menu Dashboard</div>
                    <div class="card-body">
                        <ul class="px-3" type="None" id="dashboard-menu">
                            <li class="dashboard-menu"><a href="{{ route('editProfile') }}" class=""> Profile</a></li>
                            <li class="dashboard-menu"><a href="{{ route('viewPets') }}" class="active"> My Pets</a></li>
                            <li class="dashboard-menu"><a href="" class=""> My Appointment</a></li>
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
                    <div class="card-header"><h5>My Pets</h5></div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <form method="GET" action="{{ route('registerPets') }}">
                                @csrf
                                <button class="btn btn-warning" type="submit">Register Pet <i class="fa-solid fa-plus"></i></button>
                            </form>
                        </div>
                        <hr class="mt-4 mb-3">
                        <div class="row gx-4 gy-3 mb-3">
                        @forelse ($userPets as $pet)
                            <div class="col-md-5">
                                <img class="pets-image-container" src="{{ asset($pet->image ? 'storage/' . $pet->image : 'gambar/Anons.png') }}" alt="Gambar Hewan">
                            </div>
                            <div class="col-md-7">
                                <h2 class="text-warning text-center">{{ $pet->namapasien }}</h2>
                                <hr class="mt-2 mb-2">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Animal Type</td>
                                            <td>{{ $pet->jenishewan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Breed</td>
                                            <td>{{ $pet->ras }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>{{ $pet->jeniskelamin }}</td>
                                        </tr>
                                        <tr>
                                            <td>Age</td>
                                            <td>{{ $pet->umur_tahun }} Tahun {{ $pet->umur_bulan }} Bulan</td>
                                        </tr>
                                        <tr>
                                            <td>Weight</td>
                                            <td>{{ $pet->berat }} kg</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row gx-4 gy-3 mb-3">
                                <div class="text-center">
                                    <!-- Tambahkan tombol Update dan Delete -->
                                    <form method="GET" action="{{ route('updatePetForms', $pet->kode_pasien) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </form>
                                    <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#deletemodal">
                                        Delete
                                    </button>
                                    <form method="POST" action="{{ route('delete_pet', $pet->kode_pasien) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-4 mb-3">
                        @empty
                        <p>Anda belum mendaftarkan hewan peliharaan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletemodalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus hewan peliharaan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('delete_pet', $pet->kode_pasien) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kGQDBBC11VcCY5u3b5CeZGxWUcXRDFVN+w4dd5Sh0a6RSg9l/5MdeZrOMbP" crossorigin="anonymous"></script>

    <!-- Skrip untuk menampilkan modal -->
    <script>
        $(document).ready(function () {
            // Event click pada tombol Delete untuk menampilkan modal
            $('.btn-delete').click(function () {
                $('#deletemodal').modal('show');
            });
        });
    </script>
</body>
</html>