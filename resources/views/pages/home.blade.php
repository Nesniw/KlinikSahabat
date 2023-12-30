@extends('layouts.master')

@section('content')

<div class="container pt-5">
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
                <!-- <div class="card-content">
                    <h2 class="card-title">Card Title</h2>
                    <p class="card-text">
                        This is a simple card example. You can replace this text with your own content.
                    </p>
                    <a href="#" class="card-link">Read More</a>
                </div> -->
            </div>
        </div>
    </div>
</div>

@endsection