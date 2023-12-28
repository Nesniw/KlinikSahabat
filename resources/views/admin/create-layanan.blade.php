@extends('layouts.admin-master')

@section('content')

    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="row gx-3">
            <!-- Account card-->
            <div class="col-md-12">
                <div class="card m-4">
                    <div class="card-header"><h3>Tambah Layanan Baru</h3></div>
                    <div class="card-body">
                        <form method="POST" action="{{ Route ('CreateLayananData') }}">
                            @csrf
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Nama Layanan)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="" required>
                                </div>
                                <!-- Form Group (Kategori Layanan ID)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="kategori_layanan">Kategori Layanan<span class="text-danger">*</span></label>
                                    <select name="kategori_layanan" class="form-control form-select" id="kategori_layanan" required>
                                        <option value="" disabled selected>Pilih Kategori Layanan</option>
                                        <option name="kategori_layanan" id="kategori_layanan" value="Pet Clinic">Pet Clinic</option>
                                        <option name="kategori_layanan" id="kategori_layanan" value="Pet Grooming">Pet Grooming</option>
                                        <option name="kategori_layanan" id="kategori_layanan" value="Pet Hotel">Pet Hotel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Jenis Hewan)-->
                                <div class="col-md-4" id="jenisHewanContainer" style="display:none;">
                                    <label class="medium mb-1" for="jenis_layanan_hewan">Jenis Hewan <span class="text-danger">*</span></label>
                                    <select name="jenis_layanan_hewan" class="form-control form-select" id="jenis_layanan_hewan" required>
                                        <option value="" disabled selected>Pilih Jenis Hewan</option>
                                        <option name="jenis_layanan_hewan" value="Anjing Kecil">Anjing Kecil</option>
                                        <option name="jenis_layanan_hewan" value="Anjing Sedang">Anjing Sedang</option>
                                        <option name="jenis_layanan_hewan" value="Anjing Besar">Anjing Besar</option>
                                        <option name="jenis_layanan_hewan" value="Kucing">Kucing</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="stokKandangContainer" style="display:none;">
                                    <label class="medium mb-1" for="stok_kandang">Stok Kandang <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="stok_kandang" name="stok_kandang" value="" required>
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Biaya Booking)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="biaya_booking">Biaya Booking <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="biaya_booking" name="biaya_booking" value="" required>
                                </div>
                                <!-- Form Group (Harga Layanan)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="harga_layanan">Harga Layanan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="harga_layanan" name="harga_layanan" value="" required>
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Deskripsi)-->
                                <div class="col-md-12">
                                    <label class="medium mb-1" for="deskripsi_layanan">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" cols="50" id="deskripsi_layanan" name="deskripsi_layanan" required></textarea>
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