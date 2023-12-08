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

                    {{-- Admin login Dashboard--}}
                    @if(Auth::user()->roles == 'Admin')
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
                            <a aria-label="my account" href="{{ route('editProfile') }}" class="">
                                <img class="imgLogo" src="gambar/Red Prof.png" width="40px" height="40px" alt="account"><br>
                            </a>
                            <label class="linkLabel">My Account</label>
                        </li>
                        <li class="nav-lists">
                            <a aria-label="my dashboard" href="{{ route('customerDashboard') }}" class="">
                                <img class="imgLogo" src="gambar/Dashb.png" width="40px" height="40px" alt="dashboard"><br>
                                <label class="linkLabel">My Dashboard</label>
                            </a>
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
                            <li class="dashboard-menu"><a href="{{ route('editProfile') }}" class="active"> Profile</a></li>
                            <li class="dashboard-menu"><a href="{{ route('viewPets') }}" class=""> My Pets</a></li>
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
                <div class="row gx-3 mb-3">
                    <!-- Account details card-->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header"><h5>Account Details</h5></div>
                            <div class="card-body">
                                <form method="post" action="{{ route('updateProfile') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (fullname)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="fullname">Fullname</label>
                                            <input class="form-control" id="fullname" name="fullname" type="text" placeholder="Enter your fullname" value="{{ old('fullname', $user->fullname) }}"  >
                                        </div>
                                        <!-- Form Group (roles)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="roles">Roles</label>
                                            <select name="roles" class="form-control form-select" id="roles" disabled>
                                                <option disabled value="Admin" @if(old('roles', $user->roles) === 'Admin') selected @endif>Admin</option>
                                                <option disabled value="Customer" @if(old('roles', $user->roles) === 'Customer') selected @endif>Customer</option>
                                                <option disabled value="Dokter" @if(old('roles', $user->roles) === 'Dokter') selected @endif>Dokter</option>
                                                <option disabled value="Groomer" @if(old('roles', $user->roles) === 'Groomer') selected @endif>Groomer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (Tanggal Lahir)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="tanggallahir">Tanggal Lahir</label>
                                            <input class="form-control" id="tanggallahir" name="tanggallahir" type="date" placeholder="Enter your birthdate" value="{{ old('tanggallahir', $user->tanggallahir) }}" required>
                                        </div>
                                        <!-- Form Group (Jenis Kelamin)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="jeniskelamin">Jenis Kelamin</label>
                                            <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin">
                                                <option value="Pria" @if(old('jeniskelamin', $user->jeniskelamin) === 'Pria') selected @endif>Pria</option>
                                                <option value="Wanita" @if(old('jeniskelamin', $user->jeniskelamin) === 'Wanita') selected @endif>Wanita</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (Email)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="email">Email address</label>
                                            <input class="form-control" id="email" name="email" type="email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" placeholder="Enter your email address" value="{{ old('email', $user->email) }}" autocomplete="email" required>
                                        </div>
                                        <!-- Form Group (Nomor Telepon)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="nomortelepon">Nomor Telepon</label>
                                            <input class="form-control" id="nomortelepon" name="nomortelepon" type="number" placeholder="Enter your phone number" value="{{ old('nomortelepon', $user->nomortelepon) }}" required>
                                        </div>
                                    </div>
                                    <!-- Form Group (Alamat)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="alamat">Alamat</label>
                                        <input class="form-control" id="alamat" name="alamat" type="text" placeholder="Enter your address" value="{{ old('alamat', $user->alamat) }}" required>
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                    @if (session('status') === 'profile-updated')
                                        <p class="text-success pt-3">Profile berhasil di ubah</p>
                                    @elseif (session('status') === 'profile-failed')
                                        <p class="text-danger pt-3">Profile gagal di ubah</p>
                                    @endif

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Change password card-->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header"><h5>Change Password</h5></div>
                            <div class="card-body">
                                <form method="post" action="{{ route('updatePassword') }}">
                                    @csrf
                                    @method('put')
                                    <!-- Form Group (current password)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="currentPassword">Current Password</label>
                                        <input class="form-control" id="current_password" name="current_password" type="password" placeholder="Enter current password">
                                    </div>
                                    <!-- Form Group (new password)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="newPassword">New Password</label>
                                        <input class="form-control" id="password" name="password" type="password" placeholder="Enter new password">
                                    </div>
                                    <!-- Form Group (confirm password)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="confirmPassword">Confirm Password</label>
                                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm new password">
                                    </div>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    @if (session('status') === 'password-updated')
                                        <p class="text-success pt-3">Password berhasil di ubah</p>
                                    @elseif (session('status') === 'password-failed')
                                        <p class="text-danger pt-3">Password gagal di ubah</p>
                                    @endif

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript code buat limit nomor telepon  -->
    <script>
        document.getElementById('nomortelepon').addEventListener('input', function () {
            if (this.value.length > 14) {
                this.setCustomValidity('Nomor telepon maksimal 14 digit');
            }
            else if (this.value.length < 12) {
                this.setCustomValidity('Nomor telepon minimal 12 digit');
            }
            else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>