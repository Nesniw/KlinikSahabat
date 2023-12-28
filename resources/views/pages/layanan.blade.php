@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Layanan-Layanan</h1>
</div> 
<div class="container pt-5">
    <div class="row mb-5">
        <div class="col-10 col-lg-6 text-center">
            <img class="round" src="gambar/Pelayanan Medis.jpg" width="300px" height="400px" alt="Layanan Medis">
        </div>
        <div class="col-10 col-lg-6 pt-5 justify">
            <h1 class="text-danger py-2">Pelayanan Medis</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius nulla ac risus ullamcorper, 
                eget scelerisque est scelerisque. Aenean lacinia erat ac arcu ultricies rutrum. Nunc sed viverra elit,
                 a ultrices quam. Curabitur varius nec dolor at rhoncus. Vestibulum eu leo cursus ante sollicitudin maximus. 
                 Vivamus non euismod magna. In tempor semper tincidunt. Integer ornare porta eros, nec ultrices sem auctor id. 
                 Morbi dignissim iaculis nibh quis consectetur. Integer luctus leo a fringilla molestie. 
            </p>
            <button class="btn btn-danger">Lihat Detail</button>
            <a class="btn btn-success" href="{{ route('ReservasiClinic') }}">Reservasi Sekarang</a>
        </div>
    </div>
    <div class="hr-theme-slash-2">
        <div class="hr-line"></div>
        <div class="hr-icon"><i class="material-icons">pets</i></div>
        <div class="hr-line"></div>
    </div>
    <div class="row py-5">
        <div class="col-10 col-lg-6 text-center">
            <img class="round" src="gambar/Grooming.jpg" width="300px" height="400px" alt="Pet Grooming">
        </div>
        <div class="col-10 col-lg-6 pt-5 justify">
            <h1 class="text-danger py-2">Pet Groming</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius nulla ac risus ullamcorper, 
                eget scelerisque est scelerisque. Aenean lacinia erat ac arcu ultricies rutrum. Nunc sed viverra elit,
                 a ultrices quam. Curabitur varius nec dolor at rhoncus. Vestibulum eu leo cursus ante sollicitudin maximus. 
                 Vivamus non euismod magna. In tempor semper tincidunt. Integer ornare porta eros, nec ultrices sem auctor id. 
                 Morbi dignissim iaculis nibh quis consectetur. Integer luctus leo a fringilla molestie. 
            </p>
            <button class="btn btn-danger">Lihat Detail</button>
            <a class="btn btn-success" href="{{ route('ReservasiPetGrooming') }}">Reservasi Sekarang</a>
        </div>
    </div>
    <div class="hr-theme-slash-2">
        <div class="hr-line"></div>
        <div class="hr-icon"><i class="material-icons">pets</i></div>
        <div class="hr-line"></div>
    </div>
    <div class="row py-5">
        <div class="col-10 col-lg-6 text-center">
            <img class="rounded shadow" src="gambar/Pet Hotel.jpg" width="600px" height="400px" alt="Pet Grooming">
        </div>
        <div class="col-10 col-lg-6 pt-5 justify">
            <h1 class="text-danger py-2">Pet Hotel</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius nulla ac risus ullamcorper, 
                eget scelerisque est scelerisque. Aenean lacinia erat ac arcu ultricies rutrum. Nunc sed viverra elit,
                 a ultrices quam. Curabitur varius nec dolor at rhoncus. Vestibulum eu leo cursus ante sollicitudin maximus. 
                 Vivamus non euismod magna. In tempor semper tincidunt. Integer ornare porta eros, nec ultrices sem auctor id. 
                 Morbi dignissim iaculis nibh quis consectetur. Integer luctus leo a fringilla molestie. 
            </p>
            <button class="btn btn-danger">Lihat Detail</button>
            <a class="btn btn-success" href="{{ route('ReservasiPetHotel') }}">Reservasi Sekarang</a>
        </div>
    </div>

</div>

@endsection