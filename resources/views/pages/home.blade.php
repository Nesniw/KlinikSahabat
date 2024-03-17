@extends('layouts.master')

@section('content')

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
    <div class="container bg-light rounded">
        
    </div>
</section><!-- End Hero -->

<section id="why-us" class="why-us mb-5">
    <div class="container">
        <div class="row justify-content-center bg-op py-5 shadow ">
            <h1 class="homeTitle text-light text-center mb-5">Merawat Hewanmu Seperti Hewan Kami</h1>
            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="icon-boxes d-flex flex-column justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-10 col-sm-10 col-md-10 col-lg-12 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <i class="fa-solid fa-house-medical"></i>
                                <h4>Pet Clinic</h4>
                                <p>Membantu, menjaga dan memelihara kesehatan hewan peliharaan Anda</p>
                            </div>
                        </div>
                        <div class="col-10 col-sm-10 col-md-10 col-lg-12 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <i class="fa-solid fa-scissors"></i>
                                <h4>Pet Grooming</h4>
                                <p>Membuat Hewan Peliharaan Anda Bersinar dari Ujung Hidung hingga Ujung Ekor</p>
                            </div>
                        </div>
                        <div class="col-10 col-sm-10 col-md-10 col-lg-12 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <i class="fa-solid fa-cat"></i>
                                <h4>Pet Hotel</h4>
                                <p>Memberikan tempat yang aman, nyaman, dan penuh perhatian untuk hewan peliharaan Anda</p>
                            </div>
                        </div>
                    </div>
                </div><!-- End .content-->
            </div>
        </div>
    </div>
</section><!-- End Why Us Section -->

<!-- Welcome Section -->
<section id="welcome" class="welcome my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-lg-6 col-md-10">
                <img class="float-lg-end mx-lg-3 shadows" src="/gambar/Foto Klinik.jpg" alt="Gambar Klinik">
            </div>
            <div class="col-10 col-lg-6 col-md-10 my-auto">
                <h6>Selamat Datang di</h6>
                <h1>Klinik Sahabat Hewan</h1>
                <p>Tempat di mana kebahagiaan dan kesehatan hewan peliharaan Anda menjadi prioritas utama bagi kami.
                    Sebagai mitra perawatan hewan Anda, kami berkomitmen untuk memberikan pelayanan terbaik dengan cinta dan perhatian,
                    yang tidak hanya menyediakan layanan kesehatan hewan yang berkualitas tinggi, tetapi juga menciptakan lingkungan yang 
                    nyaman dan ramah untuk hewan peliharaan Anda.
                </p>
                <p>
                    Tim profesional kami yang penuh kasih sayang akan berusaha semaksimal mungkin untuk membantu Anda dalam merawat dan menjaga kesehatan hewan peliharaan 
                    kesayangan Anda, sehingga setiap momen bersama mereka menjadi lebih bermakna. Dengan ini, Klinik Sahabat Hewan diharapkan dapat
                    menjadi rumah kedua yang nyaman dan aman untuk hewan peliharaan Anda.
                </p>
                <a class="btn btn-danger py-3 px-4 my-3" href="{{route('LayananPage')}}">
                    Lihat Semua Layanan
                </a>
            </div>
        </div>
    </div>
</section>  <!-- End Welcome Section -->

<!-- Our Team Section -->
<section id="our-team" class="our-team my-5">
    <div class="container team">
        <div class="row justify-content-center">
            <h2>Tim Klinik Sahabat Hewan</h2>
            <h6>Profesional dan Kompeten</h6>
            <div id="teamCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-10 col-lg-4 col-md-6 col-sm-6">
                                <img src="{{ asset('gambar/drh dafi.jpg') }}" alt="Card Image" class="card-img round">
                                <h3 class="mt-3 text-light text-center">drh Muammar Khadafi</h3>
                                <h5 class="text-warning text-center">Dokter Hewan</h5>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-10 col-lg-4 col-md-6 col-sm-6">
                                <img src="{{ asset('gambar/Dokter Random.jpg') }}" alt="Card Image" class="card-img round">
                                <h3 class="mt-3 text-light text-center">drh Ayu Putri Ningsih</h3>
                                <h5 class="text-warning text-center">Dokter Hewan</h5>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-10 col-lg-4 col-md-6 col-sm-6">
                                <img src="{{ asset('gambar/golgi.jpg') }}" alt="Card Image" class="card-img round">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-10 col-lg-3 col-md-6 col-sm-6">
                                <img src="{{ asset('gambar/corgi.jpg') }}" alt="Card Image" class="card-img round">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-10 col-lg-3 col-md-6 col-sm-6">
                                <img src="{{ asset('gambar/shiba.jpg') }}" alt="Card Image" class="card-img round">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-10 col-lg-3 col-md-6 col-sm-6">
                                <img src="{{ asset('gambar/golgi.jpg') }}" alt="Card Image" class="card-img round">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</section> <!-- End Our Team Section -->

<section id="why-us" class="why-us mb-5 more-top">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 d-flex align-items-stretch">
                <div class="content my-auto mx-auto">
                    <h6>Kenapa harus pilih</h6>
                    <h3>Klinik Sahabat Hewan?</h3>
                    <div class="text-center">
                        <a href="/about" class="more-btn">Ketahui lebih banyak <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="icon-boxes d-flex flex-column justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-10 col-sm-12 col-md-10 col-lg-12 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <img src="/gambar/Trusted.png" alt="Trusted Img" width="100px" height="100px" >
                                <h4>Terpercaya</h4>
                                <p>Telah dipercaya oleh ribuan pet owner di Tangerang</p>
                            </div>
                        </div>
                        <div class="col-10 col-sm-12 col-md-10 col-lg-12 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <img src="/gambar/Pet Doc.png" alt="Trusted Img" width="100px" height="100px" >
                                <h4>Berpengalaman</h4>
                                <p>Memiliki dokter yang telah berpengalaman lebih dari 9 tahun di bidang kesehatan hewan</p>
                            </div>
                        </div>
                        <div class="col-10 col-sm-12 col-md-10 col-lg-12 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <img src="/gambar/Expert.png" alt="Trusted Img" width="100px" height="100px" >
                                <h4>Profesional</h4>
                                <p>Tim klinik berkomitmen penuh dalam memberikan pelayanan
                                    berkualitas dan profesional
                                </p>
                            </div>
                        </div>
                    </div>
                </div><!-- End .content-->
            </div>
        </div>
    </div>
</section><!-- End Why Us Section -->

<!-- <div class="container pt-5">
    <h1 class="homeTitle">Merawat Hewanmu Seperti Hewan Kami</h1>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <img src="{{ asset('gambar/corgi.jpg') }}" alt="Card Image" class="card-img">
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="{{ asset('gambar/shiba.jpg') }}" alt="Card Image" class="card-img">
                
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="{{ asset('gambar/golgi.jpg') }}" alt="Card Image" class="card-img">
                
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="{{ asset('gambar/richie.jpg') }}" alt="Card Image" class="card-img">

            </div>
        </div>
    </div>
</div> -->



@endsection