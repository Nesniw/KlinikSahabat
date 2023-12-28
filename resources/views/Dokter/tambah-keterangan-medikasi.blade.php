@extends('layouts.admin-master')

@section('content')

    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="row gx-3">
            <!-- Account card-->
            <div class="col-md-12">
                <div class="card m-4">
                    <div class="card-header"><h4 class="text-dark">Informasi Layanan</h4></div>
                    <div class="card-body">
                        <div class="row gx-5 mb-4">
                            <!-- Form Group (Nama Layanan)-->
                            <div class="col-md-4">
                                <label class="medium mb-1" for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="{{ $transaksi->JadwalKlinik->layanan->nama_layanan }}" disabled>
                            </div>
                            <!-- Form Group (Nama Customer)-->
                            <div class="col-md-5">
                                <label class="medium mb-1" for="namalengkap">Nama Customer <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="namalengkap" name="namalengkap" value="{{ $transaksi->user->namalengkap }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label class="medium mb-1" for="namapasien">Nama Hewan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="namapasien" name="namapasien" value="{{ $transaksi->pets->namapasien }}" disabled>
                            </div>
                        </div>
                        <div class="row gx-5 mb-4">
                            <div class="col-md-3">
                                <label class="medium mb-1" for="jeniskelamin">Jenis Hewan (Jenis Kelamin) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jeniskelamin" name="jeniskelamin" value="{{ $transaksi->pets->jenishewan }} ({{ $transaksi->pets->jeniskelamin }})" disabled>
                            </div>
                            <div class="col-md-3">
                                <label class="medium mb-1" for="ras">Ras<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="Ras" name="Ras" value="{{ $transaksi->pets->ras }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label class="medium mb-1" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ $transaksi->JadwalKlinik->tanggal }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label class="medium mb-1" for="waktu">Waktu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="waktu" name="waktu" value="{{ $transaksi->JadwalKlinik->jam_mulai }} - {{ $transaksi->JadwalKlinik->jam_selesai }} WIB" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-4">
                    <div class="card-header"><h4 class="text-dark">Tambah Keterangan dan Medikasi</h4></div>
                    <div class="card-body">
                        <form method="POST" action="{{route('ProsesTambahKeteranganDanMedikasi')}}">
                            @csrf
                            <input type="hidden" name="transaksi_id" value="{{ $transaksi->transaksi_id }}">
                            <input type="hidden" name="kode_pasien" value="{{ $transaksi->pets->kode_pasien }}">
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Nama Layanan)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="keterangan_medis">Keterangan Layanan <span class="text-danger">*</span></label>
                                    <textarea class="form-control catatan" name="keterangan_medis" id="keterangan_medis" cols="50" rows="5" required>{{ $rekamMedis->keterangan_medis ?? '' }}</textarea>
                                </div>
                                <div class="col-md-1"></div>
                                <!-- Form Group (Nama Customer)-->
                                <div class="col-md-5">
                                    <label class="medium mb-1" for="medikasi">Medikasi <span class="text-danger">*</span></label>
                                    <textarea class="form-control catatan" name="medikasi" id="medikasi" cols="50" rows="3" required>{{ $rekamMedis->medikasi ?? '' }}</textarea>
                                </div>
                            </div>
                            
                            <button class="btn btn-success" type="submit" name="submit">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection