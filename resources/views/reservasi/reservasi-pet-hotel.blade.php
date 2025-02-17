@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Reservasi Pet Hotel</h1>
</div> 

<div class="container pt-5">
    <h5>
        <a class="linky" href="/">Home</a> / 
        <a class="linky" href="{{route('LayananPage')}}">Layanan</a> / 
        <a class="linky activated" href="{{route('ReservasiPetHotel')}}">Reservasi Pet Hotel</a>
    </h5>

    <div class="alert-container">
        @if(session('error'))
            <div class="alert alert-warning alert-dismissible fade show " role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="container my-5">
        <div class="card mb-4">
            <!-- Bisa diisi mx-auto -->
            <div class="card-body ">
                <form method="post" action="{{ route('GetHewanByLayanan') }}">
                    @csrf
                    <div class="row gx-3 my-5">
                        <!-- Form Group (Pilih Layanan) -->
                        <div class="col-md-6 text-center my-auto">
                            <label class="medium mb-1" for="layanan_id">Pilih Layanan Pet Hotel:</label>
                        </div>
                        
                        <div class="col-md-4 text-center"> 
                            <select class="form-select form-control" id="layanan_id" name="layanan_id" required>
                                <option value="" disabled selected>Pilih Layanan</option>
                                @foreach ($layanans as $layanan)
                                    <option value="{{ $layanan->layanan_id }}">{{ $layanan->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-12 text-center my-auto"> 
                            <button type="submit" class="btn btn-primary">Lanjut</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Close alert after 10 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 10000);

        // Close alert when close button is clicked
        $('.alert .btn-close').on('click', function() {
            $(this).closest('.alert').alert('close');
        });
    });
</script>

@endsection