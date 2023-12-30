@extends('layouts.master')

@section('content')

<div class="container about-container pt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('gambar/corgi.jpg') }}" alt="About Us Image" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2 class="section-title text-center text-danger mb-3">Tentang Klinik Sahabat Hewan</h2>
            <div class="container justify">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi.
                    Sed eget felis at justo aliquet volutpat. Integer vel nisi id lectus congue porttitor vel in elit.
                    Duis sit amet ligula eu justo luctus gravida.
                </p>
                <p>
                    Vestibulum dapibus nulla vel augue commodo, a porttitor lacus commodo.
                    Nunc varius, justo non volutpat auctor, sem neque ultricies diam, eget efficitur odio mi eget nunc.
                </p>
                <p>
                    Phasellus interdum magna vel ullamcorper varius. Donec vel metus nec lacus facilisis eleifend a vel dolor.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection