@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Reservasi Pet Clinic (Operasi)</h1>
</div> 

<div class="container pt-5">
    <h5>
        <a class="linky" href="/">Home</a> / 
        <a class="linky activated" href="{{route('LayananPage')}}">Layanan</a> / 
        <a class="linky activated" href="{{route('ReservasiClinic')}}">Reservasi Pet Clinic (Operasi)</a>
    </h5>

    <div class="container my-5">
        <div class="card mb-4">
            <!-- Bisa diisi mx-auto -->
            <div class="card-body ">
                <form method="POST" action="{{ route('chooseServiceCategory') }}">
                    @csrf

                    <div class="row gx-3 my-5">
                        <div class="col-md-6 text-center my-auto">
                            <label class="medium mb-1" for="kategori_layanan">Pilih Kategori Layanan :</label>
                        </div>
                        
                        <div class="col-md-3 text-center"> 
                            <select class="form-select form-control" id="kategori_layanan_id" name="kategori_layanan_id" required>
                                <option value="" disabled selected>Pilih Kategori Layanan</option>
                                @foreach ($kategoriLayanans as $kategoriLayanan)
                                    <option value="{{ $kategoriLayanan->kategori_layanan_id }}">{{ $kategoriLayanan->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 text-center my-auto"> 
                            <button type="submit" class="btn btn-primary">Lanjut</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection