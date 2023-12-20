@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Reservasi Layanan Medis</h1>
</div> 

<div class="container pt-5">
    <h5><a class="linky" href="/">Home</a> / <a class="linky activated" href="{{route('ReservasiClinic')}}">Reservasi Layanan</a></h5>

    <div class="container my-5">
        <div class="card mb-4">
            <!-- Bisa diisi mx-auto -->
            <div class="card-body ">
                <form method="post" action="{{ route('chooseServiceAndPet') }}">
                    @csrf
                    <div class="row gx-3 my-5">
                        <!-- Form Group (Pilih Layanan) -->
                        <div class="col-md-6 text-center my-auto">
                            <label class="medium mb-1" for="layanan_id">Pilih Layanan :</label>
                        </div>
                        
                        <div class="col-md-3 text-center"> 
                            <select class="form-select form-control" id="layanan_id" name="layanan_id" required>
                                <option value="" disabled selected>Pilih Layanan</option>
                                @foreach ($layanans as $layanan)
                                    <option value="{{ $layanan->layanan_id }}">{{ $layanan->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row gx-3 mb-5">
                        <!-- Form Group (Pilih Hewan) -->
                        <div class="col-md-6 text-center my-auto">
                            <label class="medium mb-1" for="kode_pasien">Pilih Hewan / Pasien :</label>
                        </div>
                        
                        <div class="col-md-3 text-center"> 
                            <select class="form-select form-control" id="kode_pasien" name="kode_pasien" required>
                                <option value="" disabled selected>Pilih Hewan / Pasien</option>
                                @foreach ($userPets as $pasien)
                                    <option value="{{ $pasien->kode_pasien }}">{{ $pasien->namapasien }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 text-center my-auto"> 
                            <a class="btn btn-warning" href="{{route('registerPets')}}">Register Pet <i class="fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-12 text-center my-auto"> 
                            <button type="submit" class="btn btn-primary">Lanjut</button>
                        </div>
                    </div>
                </form>

                <!-- Optional: Add a Bootstrap modal for confirmation -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to leave? Your data will be lost.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="confirmLeaveButton">Leave</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection