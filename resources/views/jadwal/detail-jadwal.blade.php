@extends('layouts.admin-master')

@section('content')

    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="row gx-3">
            <!-- Account card-->
            <div class="col-md-12">
                <div class="card m-4">
                    <div class="card-header"><h3>Detail Jadwal Pet Clinic dan Grooming</h3></div>
                    <div class="card-body">
                    <form method="GET" action="{{route('ShowJadwalKlinik')}}">
                        @csrf
                        <div class="row gx-5 mb-4">
                            <!-- Form Group (Jadwal Klinik Id)-->
                            <div class="col-md-6">
                                <label class="medium mb-1" for="jadwal_klinik_id">Jadwal Klinik Id <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jadwal_klinik_id" name="jadwal_klinik_id" value="{{ $jadwalKlinik->jadwal_klinik_id }}" readonly>
                            </div>
                            <!-- Form Group (Nama Layanan)-->
                            <div class="col-md-6">
                                <label class="medium mb-1" for="layanan_id">Nama Layanan <span class="text-danger">*</span></label>
                                <select name="layanan_id" class="form-control form-select" id="layanan_id" readonly>
                                    <option value="{{ $jadwalKlinik->layanan->nama_layanan }}" readonly>{{ $jadwalKlinik->layanan->nama_layanan }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row gx-5 mb-4">
                            <!-- Form Group (Kategori Layanan)-->
                            <div class="col-md-6">
                                <label class="medium mb-1" for="kategori_layanan">Kategori Layanan <span class="text-danger">*</span></label>
                                <select name="kategori_layanan" class="form-control form-select" id="kategori_layanan" readonly>
                                    <option value="{{ $jadwalKlinik->layanan->kategori_layanan }}" readonly>{{ $jadwalKlinik->layanan->kategori_layanan }}</option>
                                </select>
                            </div>
                            <!-- Form Group (Pekerja ID)-->
                            <div class="col-md-6">
                                <label class="medium mb-1" for="pekerja_id">Nama Pekerja <span class="text-danger">*</span></label>
                                <select name="pekerja_id" class="form-control form-select" id="pekerja_id" readonly>
                                    <option value="{{ $jadwalKlinik->pekerja->namapekerja }}" readonly>{{ $jadwalKlinik->pekerja->namapekerja }} ({{ $jadwalKlinik->pekerja->peran }})</option>
                                </select>
                            </div>
                        </div>
                        <div class="row gx-5 mb-4">
                            <!-- Form Group (Tanggal)-->
                            <div class="col-md-6">
                                <label class="medium mb-1" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $jadwalKlinik->tanggal }}" readonly>
                            </div>
                            <!-- Form Group (Jam Mulai)-->
                            <div class="col-md-3">
                                <label class="medium mb-1" for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ $jadwalKlinik->jam_mulai }}" readonly>
                            </div>
                            <!-- Form Group (Jam Selesai)-->
                            <div class="col-md-3">
                                <label class="medium mb-1" for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ $jadwalKlinik->jam_selesai }}" readonly>
                            </div>
                        </div>
                        <div class="row gx-5 mb-4">
                            <!-- Form Group (Status)-->
                            <div class="col-md-4">
                                <label class="medium mb-1" for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control form-select" id="status" readonly>
                                    <option value="{{ $jadwalKlinik->status }}">{{ $jadwalKlinik->status }}</option>
                                </select>
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Kembali</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection