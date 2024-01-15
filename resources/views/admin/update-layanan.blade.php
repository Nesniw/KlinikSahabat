@extends('layouts.admin-master')

@section('content')

    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="row gx-3">
            <!-- Account card-->
            <div class="col-md-12">
                <div class="card m-4">
                    <div class="card-header"><h3>Ubah Informasi Layanan</h3></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route ('UpdateLayananData', ['layanan_id' => $layanan->layanan_id]) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Nama Layanan)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                                </div>
                                <!-- Form Group (Kategori Layanan ID)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="kategori_layanan">Kategori Layanan<span class="text-danger">*</span></label>
                                    <select name="kategori_layanan" class="form-control form-select" id="kategori_layanan" required>
                                        <option name="kategori_layanan" id="kategori_layanan" value="Pet Clinic" @if(($layanan->kategori_layanan) === 'Pet Clinic') selected @endif>Pet Clinic</option>
                                        <option name="kategori_layanan" id="kategori_layanan" value="Pet Grooming" @if(($layanan->kategori_layanan) === 'Pet Grooming') selected @endif>Pet Grooming</option>
                                        <option name="kategori_layanan" id="kategori_layanan" value="Pet Hotel" @if(($layanan->kategori_layanan) === 'Pet Hotel') selected @endif>Pet Hotel</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Jenis Hewan)-->
                                <div class="col-md-6" id="jenisHewanContainer" @if(in_array($layanan->kategori_layanan, ['Pet Grooming', 'Pet Hotel'])) style="display:block;" @else style="display:none;" @endif>
                                    <label class="medium mb-1" for="jenis_layanan_hewan">Jenis Hewan <span class="text-danger">*</span></label>
                                    <select name="jenis_layanan_hewan" class="form-control form-select" id="jenis_layanan_hewan" @if(in_array($layanan->kategori_layanan, ['Pet Grooming', 'Pet Hotel'])) required @endif>
                                        <option value="" disabled selected>Pilih Jenis Hewan</option>
                                        <option name="jenis_layanan_hewan" value="Anjing Kecil" @if(($layanan->jenis_layanan_hewan) === 'Anjing Kecil') selected @endif>Anjing Kecil</option>
                                        <option name="jenis_layanan_hewan" value="Anjing Sedang" @if(($layanan->jenis_layanan_hewan) === 'Anjing Sedang') selected @endif>Anjing Sedang</option>
                                        <option name="jenis_layanan_hewan" value="Anjing Besar" @if(($layanan->jenis_layanan_hewan) === 'Anjing Besar') selected @endif>Anjing Besar</option>
                                        <option name="jenis_layanan_hewan" value="Kucing" @if(($layanan->jenis_layanan_hewan) === 'Kucing') selected @endif>Kucing</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="stokKandangContainer" @if($layanan->kategori_layanan === 'Pet Hotel') style="display:block;" @else style="display:none;" @endif>
                                    <label class="medium mb-1" for="stok_kandang">Stok Kandang <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="stok_kandang" name="stok_kandang" value="{{ $layanan->stok_kandang }}">
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Biaya Booking)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="biaya_booking">Biaya Booking <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="biaya_booking" name="biaya_booking" value="{{ $layanan->biaya_booking }}" required>
                                </div>
                                <!-- Form Group (Harga Layanan)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="harga_layanan">Harga Layanan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="harga_layanan" name="harga_layanan" value="{{ $layanan->harga_layanan }}" required>
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Deskripsi)-->
                                <div class="col-md-12">
                                    <label class="medium mb-1" for="deskripsi_layanan">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" cols="50" id="deskripsi_layanan" name="deskripsi_layanan" required>{{ old('deskripsi_layanan', $layanan->deskripsi_layanan) }}</textarea>
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var kategoriLayananSelect = document.getElementById('kategori_layanan');
            var jenisHewanContainer = document.getElementById('jenisHewanContainer');
            var jenisHewanSelect = document.getElementById('jenis_layanan_hewan');
            var stokKandangContainer = document.getElementById('stokKandangContainer');
            var stokKandangInput = document.getElementById('stok_kandang');

            kategoriLayananSelect.addEventListener('change', function () {
                var selectedKategoriLayanan = this.value;

                // Jika kategori layanan adalah Pet Grooming atau Pet Hotel
                if (selectedKategoriLayanan === 'Pet Grooming' || selectedKategoriLayanan === 'Pet Hotel') {
                    jenisHewanContainer.style.display = 'block';
                    jenisHewanSelect.required = true;

                    // Jika kategori layanan adalah Pet Hotel
                    if (selectedKategoriLayanan === 'Pet Hotel') {
                        stokKandangContainer.style.display = 'block';
                        stokKandangInput.required = true;
                    } else {
                        // Jika kategori layanan bukan Pet Hotel
                        stokKandangContainer.style.display = 'none';
                        stokKandangInput.required = false;
                        stokKandangInput.value = ''; // Kosongkan nilai stok kandang
                    }
                } 
                
                else {
                    // Jika kategori layanan bukan Pet Grooming atau Pet Hotel
                    jenisHewanContainer.style.display = 'none';
                    jenisHewanSelect.required = false;
                    jenisHewanSelect.value = ''; // Kosongkan nilai jenis hewan

                    stokKandangContainer.style.display = 'none';
                    stokKandangInput.required = false;
                    stokKandangInput.value = ''; 
                }
            });
        });
    </script>

@endsection