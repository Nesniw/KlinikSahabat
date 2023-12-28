@extends('layouts.master')

@section('content')

    <div class="custom-container px-4 mt-4">
        <div class="alert-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show " role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="row pt-5 gx-5">
            <div class="col mb-3">
                <a href="{{ route ('viewPets') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="col-xl-12"> 
                <div class="card mb-4">
                    <div class="card-header"><h5>Rekam Medis - {{ $userPet->namapasien }}</h5></div>
                    <div class="card-body">
                        <table class="table table-bordered" style="border-width:2px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th width="120px">Tanggal</th>
                                    <th width="200px">Nama Dokter</th>
                                    <th>Keterangan Layanan</th>
                                    <th>Medikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($rekamMedis->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Hewan tidak memiliki rekam medis</td>
                                    </tr>
                                @else
                                    @foreach ($rekamMedis as $index => $medis)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $medis->transaksi->tanggal }}</td>
                                            <td>{{ $medis->transaksi->JadwalKlinik->pekerja->namapekerja }}</td>
                                            <td class="justify">{{ $medis->keterangan_medis }}</td>
                                            <td class="justify">{{ $medis->medikasi }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection