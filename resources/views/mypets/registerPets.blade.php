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
                                <img class="imgLogo" src="{{asset('gambar/Dashb.png')}}" width="40px" height="40px" alt="dashboard"><br>
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
                    <div class="card-header"><h5>Register Pets</h5></div>
                    <div class="card-body px-5">
                        <form method="POST" action="{{ route('register_pet') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gx-5 mb-3">
                                <!-- Form Group (Kode Pasien)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="kode_pasien">Kode Pasien</label>
                                    <input class="form-control" id="kode_pasien" name="kode_pasien" type="text" value="{{ $randomCode }}" readonly>
                                </div>
                                <!-- Hanya untuk keperluan melihat USER ID
                                <div class="col-md-3">
                                    <label class="small mb-1" for="user_id">User ID</label>
                                    <input class="form-control" id="user_id" name="user_id" type="text" value="{{ old('user_id', $user->user_id) }}" readonly>
                                </div> -->
                                <!-- Form Group (Nama Pasien)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="namapasien">Nama Pasien <span class="text-danger">*</span></label>
                                    <input class="form-control" id="namapasien" name="namapasien" type="text" value="" placeholder="Masukkan Nama Pasien" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5 mb-3">
                                <!-- Form Group (Jenis Hewan)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="jenishewan">Jenis hewan <span class="text-danger">*</span></label>
                                    <select name="jenishewan" class="form-control form-select" id="jenishewan" required>
                                        <option value="" disabled selected>Pilih Jenis Hewan</option>
                                        <option name="jenishewan" id="jenishewan" value="Anjing">Anjing</option>
                                        <option name="jenishewan" id="jenishewan" value="Kucing">Kucing</option>
                                        <option name="jenishewan" id="jenishewan" value="Kelinci">Kelinci</option>
                                        <option name="jenishewan" id="jenishewan" value="Burung">Burung</option>
                                        <option name="jenishewan" id="jenishewan" value="Hamster">Hamster</option>
                                        <option name="jenishewan" id="jenishewan" value="Ayam">Ayam</option>
                                    </select>
                                </div>
                                <!-- Form Group (Ras)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="ras">Ras Hewan <span class="text-danger">*</span></label>
                                    <input class="form-control" id="ras" name="ras" type="text" value="" placeholder="Masukkan Ras Hewan" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5 mb-3">
                                <!-- Form Group (Jenis Kelamin)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="jeniskelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option name="jeniskelamin" id="jeniskelamin" value="Laki-Laki">Laki-Laki</option>
                                        <option name="jeniskelamin" id="jeniskelamin" value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <!-- Form Group (Berat Hewan)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="berat">Berat Hewan (kg) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="berat" name="berat" type="number" placeholder="Masukkan Berat Hewan" value="" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5 mb-3">
                                <!-- Form Group (Umur Tahun)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="umur_tahun">Umur Hewan (Tahun) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="umur_tahun" name="umur_tahun" type="number" max="25" placeholder="Masukkan Umur Tahun Hewan" value="" required>
                                </div>
                                <!-- Form Group (Umur Bulan)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="umur_bulan">Umur Hewan (Bulan) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="umur_bulan" name="umur_bulan" type="number" max="11" placeholder="Masukkan Umur Bulan Hewan" value="" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5 mb-3">
                                <!-- Form Group (Tipe Darah)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="tipedarah">Tipe Darah</label>
                                    <input class="form-control" id="tipedarah" name="tipedarah" type="text" placeholder="Masukkan Tipe Darah" value="">
                                </div>
                                <!-- Form Group (Alergi)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="alergi">Alergi</label>
                                    <input class="form-control" id="alergi" name="alergi" type="text" placeholder="Masukan Alergi" value="">
                                </div>
                            </div>
                            <!-- Form Group (Upload Gambar)-->
                            <div class="row gx-5 mb-3">
                                <div class="col-md-4">
                                    <label class="small mb-1" for="image">Unggah Gambar</label>
                                    <input class="form-control" id="image" name="image" type="file">
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Menambahkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>