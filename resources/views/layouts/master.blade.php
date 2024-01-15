<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Klinik Sahabat Hewan</title>
	<link rel="shortcut icon" href="{{ asset('gambar/Logo Klinik Sahabat Hewan Clear.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&family=Roboto:wght@500&family=Salsa&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tZ1a9lLJZeuZ6X5PvZl1Wr1l7QNd55X3s7qF0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.0.7/dist/countUp.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="navBar-container sticky-top" id="navbar">
        <div class="row align-items-center justify-content-center mx-auto">
            <div class="col-md-12 col-lg-2 col-xl-2 klinik-title Centering">
                Klinik <span>Sahabat</span><br> Hewan 
            </div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <img src="/gambar/Logo Klinik Sahabat Hewan.png" width="70px" height="70px" alt=""></span>
            </div>
            <div class="navig col-8 col-sm-8 col-md-8 col-lg-7 col-xl-7 roboto">
                <p class="Centering pJudul my-auto">
                    Klinik <span>Sahabat</span> Hewan 
                </p>
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
            </div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 calistoga Centering">
                <a href="#" class="tombol-menu">
                    <i class="fa-solid fa-bars" id="menuIcon"></i>
                </a>
                @auth('pekerja')
                    {{-- Admin, Dokter, Groomer login Dashboard --}}
                    <ul class="nav justify-content-center" type="None">
                        <!-- <li class="nav-lists">
                            <a aria-label="my account" href="#" class="">
                                <img class="imgLogo" src="{{ asset('gambar/Red Prof.png') }}" width="40px" height="40px" alt="account"><br>
                                <label class="linkLabel">My Account</label>
                            </a>
                        </li> -->
                        <li class="nav-lists">
                            <a aria-label="my dashboard" href="{{ route('AdminDashboard') }}" class="">
                                <img class="imgLogo" src="{{ asset('gambar/Dashb.png') }}" width="40px" height="40px" alt="dashboard"><br>
                                <label class="linkLabel">Admin Dashboard</label>
                            </a>
                        </li>
                    </ul> 
                @else
                    @guest
                        {{-- Belum login --}}
                        <a class="btnLink" href="{{ route('login') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Login</a>
                        <!-- <a class="btnLink" href="{{ route('pekerja.login') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Admin Login</a> -->
                    @else
                        {{-- Customer login Dashboard --}}
                        <ul class="nav justify-content-center" type="None">
                            <li class="nav-lists">
                                <a aria-label="my dashboard" href="{{ route('editProfile') }}" class="">
                                    <img class="imgLogo" src="{{ asset('gambar/Dashb.png') }}" width="40px" height="40px" alt="dashboard"><br>
                                    <label class="linkLabel">My Dashboard</label>
                                </a>
                            </li>
                        </ul>
                    @endguest
                @endauth
            </div>
        </div>
        <nav>
            <div class="wrapper">
                <div class="menu" id="menuLinks">
                    <ul>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/layanan">Layanan</a></li>
                        <li><a href="/about">Tentang</a></li>
                        <li><a href="/contactus">Hubungi Kami</a></li>
                        @auth('pekerja')
                            <li><a class="btn btn-dark p-3" href="{{ route('AdminDashboard') }}">Admin Dashboard</a></li>
                        @else
                            @guest
                                <li><a class="btn btn-dark p-3" href="{{ route('login') }}">Login</a></li>
                            @else
                                <li><a class="btn btn-dark p-3" href="{{ route('editProfile') }}">My Dashboard</a></li>
                            @endguest
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="main-container">
        @yield('content')
    </div>
    
    <!-- <footer class="top">
        <img src="/gambar/Logo Klinik Sahabat Hewan.png" alt="Logo Klinik Sahabat Hewan">
        <div class="links">
            <div>
                <h2>Hubungi Kami</h2>
                <p>WA: 0811-1345-710</p>
                <p>Jalan Raya Villa Tangerang Indah Blok BE 01 No.14, RT.004/RW.12 Gebang Raya, Kecamatan Periuk, Kota Tangerang, Banten 15132</p>
            </div>
            <div>
                <h2>Layanan</h2>
                <ul type="circle">
                    <li><a href="#">Pet Clinic</a></li>
                    <li><a href="#">Pet Grooming</a></li>
                    <li><a href="#">Pet Hotel</a></li>
                </ul>
            </div>
            <div>
                <h2>Jam Buka</h2>

            </div>
        </div>
    </footer> -->

    <footer>
        <div class="footer-section">
            <h3>Klinik <span>Sahabat</span> Hewan</h3>
            <ul class="nav justify-content-start" type="None">
                <li>
                    <a href="#" class="icon-link">
                        <img src="/gambar/Insta.png" alt="Custom Icon" class="icon">
                    </a>
                </li>
                <li>
                    <a href="#" class="icon-link">
                        <img src="/gambar/WA.png" alt="Custom Icon" class="icon">
                    </a>
                </li>
                <li>
                    <a href="#" class="icon-link">
                        <img src="/gambar/Gmaps.png" alt="Custom Icon" class="icon">
                    </a>
                </li>
            </ul>
            <p>Copyright © 2023<br>
            Klinik Sahabat Hewan | All Rights Reserved </p>
        </div>

        <div class="footer-section">
            <h3>Hubungi Kami</h3>
            <p>WA: 0811-1345-710</p>
            <p>Jalan Raya Villa Tangerang Indah, Blok BE 01 No.14, RT.004/RW.12, Gebang Raya, Kecamatan Periuk, Kota Tangerang, Banten 15132</p>
        </div>

        <div class="footer-section">
            <h3>Layanan</h3>
            <ul type="bullet">
                <li><a href="#">Pet Clinic</a></li>
                <li><a href="#">Pet Grooming</a></li>
                <li><a href="#">Pet Hotel</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Jam Buka</h3>
            <p>Setiap hari <br>09:00 - 21:00.</p>
        </div>
    </footer>

    <!--Bootstrap Script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.container').click(function() {
                var jadwalKlinikId = $(this).data('jadwal-klinik-id');
                // Assuming you have a form with ID 'your-form-id'
                $('#your-form-id input[name="jadwal_klinik_id"]').val(jadwalKlinikId);
                $('#your-form-id').submit();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('.tombol-menu');
            const menuLinks = document.getElementById('menuLinks');
            const menuIcon = document.getElementById('menuIcon');

            menuButton.addEventListener('click', function(e) {
                e.preventDefault();
                menuLinks.classList.toggle('active');

                // Toggle ikon 'bars' dan 'x'
                menuIcon.classList.toggle('fa-bars');
                menuIcon.classList.toggle('fa-times');
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    menuLinks.classList.remove('active');

                    // Pastikan ikon kembali ke tanda 'bars' jika layar cukup lebar
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });
        });
    </script>

    <!-- Script buat penentu navlinks aktif -->
    <script>
        // Get the current page URL
        let currentUrl = window.location.pathname;

        // Get all navigation links
        let navLinks = document.querySelectorAll('.navLinks');

        // Loop through each link and check if its href matches the current URL
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentUrl) {
                link.classList.add('active'); // Add the 'active' class to the matching link
            }
        });
    </script>
    
</body>
</html>