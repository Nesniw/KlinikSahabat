@extends('layouts.admin-master')

@section('content')


    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="row gx-3">
            <!-- Account card-->
            <div class="col-md-12">
                <div class="card m-4">
                    <div class="card-header"><h3>Tambah Jadwal Pet Clinic</h3></div>
                    <div class="card-body">
                        <form method="POST" action="{{ Route ('CreateJadwalKlinik') }}">
                            @csrf
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Nama Layanan)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="layanan_id">Nama Layanan <span class="text-danger">*</span></label>
                                    <select name="layanan_id" class="form-control form-select" id="layanan_id" required>
                                        <option value="" disabled selected>Pilih Nama Layanan</option>
                                        @foreach($layanan as $lay)
                                            <option value="{{ $lay->layanan_id }}">{{ $lay->kategori_layanan }} - {{ $lay->nama_layanan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Form Group (Pekerja ID)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="pekerja_id">Nama Pekerja <span class="text-danger">*</span></label>
                                    <select name="pekerja_id" class="form-control form-select" id="pekerja_id" required>
                                        <option value="" disabled selected>Pilih Nama Pekerja</option>
                                        @foreach($pekerja as $pk)
                                            @if($pk->peran == 'Dokter')
                                                <option value="{{ $pk->pekerja_id }}">{{ $pk->namapekerja }} ({{ $pk->peran }})</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Tanggal)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                            min="{{ now()->addDay()->format('Y-m-d') }}"
                                            max="{{ now()->addDays(7)->format('Y-m-d') }}" required>
                                </div>
                                <!-- Form Group (Jam Mulai)-->
                                <div class="col-md-3">
                                    <label class="medium mb-1" for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" min="09:00" max="16:59" required>
                                </div>
                                <!-- Form Group (Jam Selesai)-->
                                <div class="col-md-3">
                                    <label class="medium mb-1" for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" min="09:00" max="16:59" required>
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Status)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control form-select" id="status" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection