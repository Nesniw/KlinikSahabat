@extends('layouts.master')

@section('content')

<div class="imageContainer">
    <h1 class="homeTitle">Reservasi Pet Clinic (Operasi)</h1>
</div> 

<div class="container pt-5">
    <h5 class="Centering">
        <a class="linky" href="/">Home</a> / 
        <a class="linky" href="{{route('LayananPage')}}">Layanan</a> / 
        <a class="linky activated" href="{{route('ReservasiClinic')}}">Reservasi Pet Clinic (Operasi)</a>
    </h5>
    
    
    <div class="container my-5">
        <div class="card mb-4">
            <!-- Bisa diisi mx-auto -->
            <div class="card-body ">
                <form method="POST" action="{{ route('chooseSchedule') }}">
                    @csrf
                    <div class="text-center mt-4">
                        <h3 class="medium mb-1 text-secondary">Pilih Jadwal :</h3>
                    </div>
                    <div class="row gx-3 mb-5">
                        <div class="col-md-12">
                            @if(isset($noSchedules) && $noSchedules)
                                <div class="container text-center my-5 text-danger">
                                    <h4>Tidak ada jadwal tersedia.</h4>
                                </div>
                            @else
                                @foreach ($groupedJadwals as $worker => $workerGroup)
                                    <div class="container mt-5">
                                        <h4 class="text-warning">{{ $worker }}</h4> 
                                    </div>
                                    @foreach ($workerGroup as $date => $schedules)
                                        <div class="container mt-4 ms-3 mb-2 text-secondary">
                                            {{ $date }} <br>
                                        </div>
                                        <div class="container flex-container flex-wrap ms-3">
                                            @foreach ($schedules as $jadwal)
                                                <div class="me-2">
                                                    <ul class="custom-radio">
                                                        <li> 
                                                            <input type="radio" name="jadwal_klinik_id" value="{{ $jadwal->jadwal_klinik_id }}" id="radio{{ $jadwal->jadwal_klinik_id }}" required>
                                                            <label class="" for="radio{{ $jadwal->jadwal_klinik_id }}">
                                                                {{$jadwal->getNamaHariAttribute()}}, {{ $jadwal->tanggal }} <br> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WIB <br>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @if(!isset($noSchedules) || !$noSchedules)
                        <div class="row gx-3 mb-5">
                            <div class="col-md-12 text-center my-auto"> 
                                <button type="submit" class="btn btn-primary">Lanjut</button>
                            </div>
                        </div>
                    @else
                        <div class="row gx-3 mb-5">
                            <div class="col-md-12 text-center my-auto"> 
                                <a href="{{route('ReservasiClinic')}}" class="btn btn-danger mt-3">Kembali</a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@endsection