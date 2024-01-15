@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Layanan</h1>
</div> 
<div class="container layanan pt-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-12 col-lg-6 text-center">
            <img class="round shadow" src="gambar/Doctor giving medical service.png" width="450px" height="400px" alt="Layanan Medis">
        </div>
        <div class="col-10 col-lg-6 my-auto justify">
            <h1 class="text-danger pb-2">Pet Clinic</h1>
            <p>
                Klinik Sahabat Hewan menyediakan beragam layanan medis yang komprehensif untuk memastikan kesehatan dan kesejahteraan optimal hewan peliharaan Anda. 
                Layanan medis yang tersedia di Klinik Sahabat Hewan berupa konsultasi dengan dokter hewan, check-up / pemeriksaan rutin, vaksinasi, sterilisasi,
                dan layanan operasi. Layanan rawat inap juga tersedia untuk hewan peliharaan yang membutuhkan perawatan lebih lanjut setelah mendapatkan layanan dari
                dokter hewan.
            </p>
            <p class="text-danger">Reservasi layanan medis hanya tersedia untuk layanan operasi, dan untuk layanan medis lainnya dapat datang langsung ke klinik</p>
            <!-- <button class="btn btn-danger">Lihat Detail</button> -->
            <a class="btn btn-success" href="{{ route('ReservasiClinic') }}">Reservasi Sekarang</a>     
        </div>
    </div>
    <div class="hr-theme-slash-2">
        <div class="hr-line"></div>
        <div class="hr-icon"><i class="material-icons">pets</i></div>
        <div class="hr-line"></div>
    </div>
    <div class="row py-5 justify-content-center">
        <div class="col-12 col-lg-6 text-center">
            <img class="round shadow" src="gambar/Groomer giving grooming service.png" width="450px" height="400px" alt="Pet Grooming">
        </div>
        <div class="col-10 col-lg-6 my-auto justify">
            <h1 class="text-danger pb-2">Pet Groming</h1>
            <p>
                Klinik Sahabat Hewan menyediakan layanan grooming yang hadir untuk memberikan perawatan menyeluruh dan penuh perhatian dalam menjaga kebersihan 
                dan kesejahteraan hewan peliharaan Anda. Melalui layanan Grooming Klinik Sahabat Hewan, kami menawarkan pengalaman grooming terbaik yang memastikan
                hewan peliharaan Anda tetap bersih, nyaman, dan sehat.
            </p>
            <p class="text-danger">Layanan grooming juga termasuk proses mandi dan trimming bulu, cukur bulu telapak kaki, cukur
                bulu pantat, potong kuku, dan pembersihan telingan.</p>
            <!-- <button class="btn btn-danger">Lihat Detail</button> -->
            <a class="btn btn-success" href="{{ route('ReservasiPetGrooming') }}">Reservasi Sekarang</a>
        </div>
    </div>
    <div class="hr-theme-slash-2">
        <div class="hr-line"></div>
        <div class="hr-icon"><i class="material-icons">pets</i></div>
        <div class="hr-line"></div>
    </div>
    <div class="row py-5 justify-content-center">
        <div class="col-12 col-lg-6 my-auto text-center">
            <img class="round shadow" src="gambar/Pet Services.png" width="450px" height="400px" alt="Pet Grooming">
        </div>
        <div class="col-10 col-lg-6 justify">
            <h1 class="text-danger py-2">Pet Hotel</h1>
            <p>
                Klinik Sahabat Hewan menyediakan layanan Pet Hotel yang hadir untuk memberikan sebuah tempat tinggal sementara di mana hewan peliharaan Anda dapat 
                menikmati penginapan yang nyaman, aman, dan penuh perhatian ketika Anda tidak dapat bersama mereka. Selain mendapatkan tempat tinggal sementara
                selayaknya dirumah sendiri, setiap kebutuhan hewan peliharaan Anda akan tetap terpenuhi dan mendapatkan perhatian penuh dari tim klinik.
            </p>
            <p class="mb-1">Fasilitas yang termasuk dalam layanan pet hotel, antara lain:</p>
            <ul>
                <li>Kandang Privat / 1 Kandang 1 Anabul</li>
                <li>Free pasir wangi & litter box</li>
                <li>Ruangan AC</li>
                <li>CCTV 24 jam</li>
                <li>Dibawah pengawasan dokter hewan</li>
            </ul>
            <p class="text-danger">* Layanan pet hotel tidak termasuk makanan anabul, sehingga diharapkan pemilik mempersiapkan makanan anabul atau membeli pada pet shop</p>
            <!-- <button class="btn btn-danger">Lihat Detail</button> -->
            <a class="btn btn-success" href="{{ route('ReservasiPetHotel') }}">Reservasi Sekarang</a>
        </div>
    </div>

</div>

@endsection