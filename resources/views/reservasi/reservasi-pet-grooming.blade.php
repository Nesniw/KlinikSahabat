@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Reservasi Pet Grooming</h1>
</div> 

<div class="container pt-5">
    <h5 class="Centering">
        <a class="linky" href="/">Home</a> / 
        <a class="linky" href="{{route('LayananPage')}}">Layanan</a> / 
        <a class="linky activated" href="{{route('ReservasiPetGrooming')}}">Reservasi Pet Grooming</a>
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
                <form method="post" action="{{ route('GetHewanGroomingByLayanan') }}">
                    @csrf
                    <div class="row gx-3 my-5">
                        <!-- Form Group (Pilih Layanan) -->
                        <div class="col-md-6 text-center my-auto">
                            <label class="medium mb-1" for="layanan_id"><span class="text-danger">*</span> Pilih Layanan Pet Grooming :</label>
                        </div>
                        
                        <div class="col-md-4 text-center"> 
                            <select class="form-select form-control" id="layanan_id" name="layanan_id" required>
                                <option value="" disabled selected>Pilih Layanan </option>
                                @foreach ($layanans as $layanan)
                                    <option value="{{ $layanan->layanan_id }}">{{ $layanan->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Catatan Untuk Groomer -->
                    <div class="row gx-3 mb-5">
                        <div class="col-md-6 text-center my-auto"> 
                            <label class="medium mb-1" for="catatan"></span> Request Model Potong & Catatan Tambahan :
                                <br><br><p class="text-danger">Jika tidak diisi, maka model cukur akan dipilihkan cukur pendek</p>
                            </label>
                            
                        </div>
                        <div class="col-md-4 text-center"> 
                            <textarea class="form-control catatan" rows="4" cols="50" id="catatan" name="catatan" 
                            placeholder="Harap sertakan informasi model potongan hewan yang diinginkan, dan keterangan tambahan yang perlu diperhatikan Groomer jika ada"></textarea>
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