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
                                <label class="medium mb-1" for="kategori_layanan">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_layanan" class="form-control" id="kategori_layanan" readonly>
                                    <option value="{{ $transaksi->layanan->kategori_layanan }}" readonly>{{ $transaksi->layanan->kategori_layanan }}</option>
                                </select>
                            </div>
                            <!-- Form Group (Nama Layanan)-->
                            <div class="col-md-5">
                                <label class="medium mb-1" for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                                <select name="nama_layanan" class="form-control" id="nama_layanan" readonly>
                                    <option value="{{ $transaksi->layanan->nama_layanan }}" readonly>{{ $transaksi->layanan->nama_layanan }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row gx-5 mb-4">
                            <div class="col-md-6">
                                <label class="medium mb-1" for="namalengkap">Nama Customer <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="namalengkap" name="namalengkap" value="{{ $transaksi->User->namalengkap }}" readonly>
                            </div>
                            @if ($transaksi->layanan->kategori_layanan === 'Pet Clinic')
                                <!-- Form Group (Pekerja ID)-->
                                <div class="col-md-5">
                                    <label class="medium mb-1" for="namapekerja">Nama Pekerja <span class="text-danger">*</span></label>
                                    <select name="namapekerja" class="form-control" id="namapekerja" readonly>
                                        <option value="{{ $transaksi->JadwalKlinik->pekerja->namapekerja }}" readonly>{{ $transaksi->JadwalKlinik->pekerja->namapekerja }} ({{ $transaksi->JadwalKlinik->pekerja->peran }})</option>
                                    </select>
                                </div>
                            @elseif ($transaksi->layanan->kategori_layanan === 'Pet Grooming')
                                <!-- Form Group (Tanggal)-->
                                <div class="col-md-4">
                                    <label class="medium mb-1" for="tanggal">Tanggal Grooming <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $transaksi->tanggal }}" readonly>
                                </div>
                            @else
                                <!-- Form Group (Tanggal)-->
                                <div class="col-md-4">
                                    <label class="medium mb-1" for="tanggal">Tanggal Check-in <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $transaksi->tanggal }}" readonly>
                                </div>
                            @endif
                        </div>
                        <div class="row gx-5 mb-4">
                            @if ($transaksi->layanan->kategori_layanan === 'Pet Clinic')
                                <!-- Form Group (Tanggal)-->
                                <div class="col-md-4">
                                    <label class="medium mb-1" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $transaksi->jadwalKlinik->tanggal }}" readonly>
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

                            @elseif ($transaksi->layanan->kategori_layanan === 'Pet Grooming')
                                 <!-- Form Group (Waktu)-->
                                 <div class="col-md-3">
                                    <label class="medium mb-1" for="waktu">Waktu Grooming <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="waktu" name="waktu" value="{{ $transaksi->waktu }}" readonly>
                                </div>
                                <!-- Form Group (Tanggal CO)-->
                                
                            @elseif ($transaksi->layanan->kategori_layanan === 'Pet Hotel')
                                <!-- Form Group (Waktu)-->
                                <div class="col-md-3">
                                    <label class="medium mb-1" for="waktu">Waktu Check-in <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="waktu" name="waktu" value="{{ $transaksi->waktu }}" readonly>
                                </div>
                                <!-- Form Group (Lama Inap)-->
                                <div class="col-md-3">
                                    <label class="medium mb-1" for="lama_tinggal">Lama Inap (Hari)<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="lama_tinggal" name="lama_tinggal" value="{{ $transaksi->lama_tinggal }}" readonly> 
                                </div>
                                <!-- Form Group (Tanggal CO)-->
                                <div class="col-md-4">
                                    <label class="medium mb-1" for="tanggal">Estimasi Tanggal Check-out <span class="text-danger">*</span></label>
                                    <input class="form-control" id="tanggal" name="tanggal" value="{{ $estimasiCheckout->format('d/m/Y') }}" readonly>
                                </div>
                            @endif
                        </div>
                        <div class="row gx-5 mb-4">
                            <!-- Form Group (Status)-->
                            <div class="col-md-4">
                                <label class="medium mb-1" for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control " id="status" readonly>
                                    <option value="{{ $transaksi->status }}">{{ $transaksi->status }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="medium mb-1" for="total_biaya">Total Biaya <span class="text-danger">*</span></label>
                                <select name="total_biaya" class="form-control " id="total_biaya" readonly>
                                    <option value="{{ $transaksi->total_biaya }}">Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</option>
                                </select>
                            </div>
                        </div>
                        @if ($transaksi->layanan->kategori_layanan === 'Pet Clinic')
                            <div class="row gx-5 mb-4">
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="keterangan_medis">Keterangan Layanan <span class="text-danger">*</span></label>
                                    <textarea class="form-control catatan" name="keterangan_medis" id="keterangan_medis" cols="50" rows="5" readonly>{{ $transaksi->rekamMedis->keterangan_medis ?? '' }}</textarea>
                                </div>
                                <div class="col-md-5">
                                    <label class="medium mb-1" for="medikasi">Medikasi <span class="text-danger">*</span></label>
                                    <textarea class="form-control catatan" name="medikasi" id="medikasi" cols="50" rows="3" readonly>{{ $transaksi->rekamMedis->medikasi ?? '' }}</textarea>
                                </div>
                            </div>
                        @endif
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Kembali</button>
                    </form>
                    @if ($transaksi->layanan->kategori_layanan === 'Pet Clinic' && $transaksi->status === 'Pembayaran Berhasil' && $transaksi->rekamMedis)
                        <form method="POST" action="{{ route('SelesaikanTransaksi', $transaksi->transaksi_id) }}" class="float-end">
                            @csrf
                            @method('PATCH') 
                            <button class="btn btn-success" type="submit">
                                Selesaikan Transaksi
                            </button>
                        </form>

                    @elseif ($transaksi->layanan->kategori_layanan === 'Pet Hotel' && $transaksi->status === 'Pembayaran Berhasil' && now() < \Carbon\Carbon::parse($transaksi->estimasiCheckout))
                        <form method="POST" action="{{ route('SelesaikanTransaksi', $transaksi->transaksi_id) }}" class="float-end">
                            @csrf
                            @method('PATCH') 
                            <button class="btn btn-success" type="submit">
                                Selesaikan Transaksi
                            </button>
                        </form>

                    @elseif ($transaksi->layanan->kategori_layanan === 'Pet Grooming' && $transaksi->status === 'Proses Grooming Selesai')
                        <form method="POST" action="{{ route('SelesaikanTransaksi', $transaksi->transaksi_id) }}" class="float-end">
                            @csrf
                            @method('PATCH') 
                            <button class="btn btn-success" type="submit">
                                Selesaikan Transaksi
                            </button>
                        </form>

                    @elseif (($transaksi->status === 'Menunggu Pembayaran' || $transaksi->status === 'Pembayaran Gagal') && now() >= \Carbon\Carbon::parse($transaksi->waktu_ekspirasi))
                        <form method="POST" action="{{ route('NonaktifkanTransaksi', $transaksi->transaksi_id) }}" class="float-end">
                            @csrf
                            @method('PATCH') 
                            <button class="btn btn-danger" type="submit">
                                Nonaktifkan Transaksi
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection