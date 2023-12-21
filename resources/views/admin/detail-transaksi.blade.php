@extends('layouts.admin-master')

@section('content')

<div class="container bg-white shadow p-3 mb-5 bg-white rounded">
    <div class="row gx-3">
        <!-- Account card-->
        <div class="col-md-12">
            <div class="card m-4">
                <div class="card-header"><h3>Detail Transaksi</h3></div>
                <div class="card-body">
                <form method="GET" action="{{route('ShowTransaksi')}}">
                    @csrf
                    <div class="row gx-5 mb-4">
                        <!-- Form Group (Jadwal Klinik Id)-->
                        <div class="col-md-3">
                            <label class="medium mb-1" for="transaksi_id">ID Transaksi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="transaksi_id" name="transaksi_id" value="{{ $transaksi->transaksi_id }}" readonly>
                        </div>
                        <!-- Form Group (Kategori Layanan)-->
                        <div class="col-md-3">
                            <label class="medium mb-1" for="nama_kategori">Kategori <span class="text-danger">*</span></label>
                            <select name="nama_kategori" class="form-control" id="nama_kategori" readonly>
                                <option value="{{ $transaksi->JadwalKlinik->layanan->KategoriLayanan->nama_kategori }}" readonly>{{ $transaksi->JadwalKlinik->layanan->kategoriLayanan->nama_kategori }}</option>
                            </select>
                        </div>
                        <!-- Form Group (Nama Layanan)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                            <select name="nama_layanan" class="form-control" id="nama_layanan" readonly>
                                <option value="{{ $transaksi->JadwalKlinik->layanan->nama_layanan }}" readonly>{{ $transaksi->JadwalKlinik->layanan->nama_layanan }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row gx-5 mb-4">
                        <div class="col-md-6">
                            <label class="medium mb-1" for="namalengkap">Nama Customer <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="namalengkap" name="namalengkap" value="{{ $transaksi->User->namalengkap }}" readonly>
                        </div>
                        <!-- Form Group (Pekerja ID)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="namapekerja">Nama Pekerja <span class="text-danger">*</span></label>
                            <select name="namapekerja" class="form-control" id="namapekerja" readonly>
                                <option value="{{ $transaksi->JadwalKlinik->pekerja->namapekerja }}" readonly>{{ $transaksi->JadwalKlinik->pekerja->namapekerja }} ({{ $transaksi->JadwalKlinik->pekerja->peran }})</option>
                            </select>
                        </div>
                    </div>
                    <div class="row gx-5 mb-4">
                        <!-- Form Group (Tanggal)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $transaksi->JadwalKlinik->tanggal }}" readonly>
                        </div>
                        <!-- Form Group (Jam Mulai)-->
                        <div class="col-md-3">
                            <label class="medium mb-1" for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ $transaksi->jadwalKlinik->jam_mulai }}" readonly>
                        </div>
                        <!-- Form Group (Jam Selesai)-->
                        <div class="col-md-3">
                            <label class="medium mb-1" for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ $transaksi->jadwalKlinik->jam_selesai }}" readonly>
                        </div>
                    </div>
                    <div class="row gx-5 mb-4">
                        <!-- Form Group (Status)-->
                        <div class="col-md-4">
                            <label class="medium mb-1" for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control " id="status" readonly>
                                <option value="{{ $transaksi->status }}">{{ $transaksi->status }}</option>
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