@extends('layouts.master')

@section('content')

    <div class="custom-container px-4 mt-4">
        <div class="row pt-5 gx-5">
            <div class="col-xl-3">
                <!-- Menu card-->
                <div class="card mb-4">
                    <div class="card-header text-danger">Menu Dashboard</div>
                    <div class="card-body">
                        <ul class="px-3" type="None" id="dashboard-menu">
                            <li class="dashboard-menu"><a href="{{ route('editProfile') }}" class=""> Profile</a></li>
                            <li class="dashboard-menu"><a href="{{ route('viewPets') }}" class="active"> My Pets</a></li>
                            <li class="dashboard-menu"><a href="{{ route('ViewTransaksi') }}" class=""> My Transaksi</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Logout card-->
                <div class="card mb-4">
                    <div class="card-header text-danger">Keluar dari Akun saat ini</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-9"> 
                <div class="card mb-4">
                    <div class="card-header"><h5>Tambah Pet</h5></div>
                    <div class="card-body px-5">
                        <form method="POST" action="{{ route('register_pet') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gx-5">
                                <!-- Form Group (Kode Pasien)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="kode_pasien">Kode Pasien</label>
                                    <input class="form-control" id="kode_pasien" name="kode_pasien" type="text" value="{{ $randomCode }}" readonly>
                                </div>
                                <!-- Hanya untuk keperluan melihat USER ID
                                <div class="col-md-3">
                                    <label class="small mb-1" for="user_id">User ID</label>
                                    <input class="form-control" id="user_id" name="user_id" type="text" value="{{ old('user_id', $user->user_id) }}" readonly>
                                </div> -->
                                <!-- Form Group (Nama Pasien)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="namapasien">Nama Pasien <span class="text-danger">*</span></label>
                                    <input class="form-control" id="namapasien" name="namapasien" type="text" value="" placeholder="Masukkan Nama Pasien" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5">
                                <!-- Form Group (Jenis Hewan)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="jenishewan">Jenis hewan <span class="text-danger">*</span></label>
                                    <select name="jenishewan" class="form-control form-select" id="jenishewan" required>
                                        <option value="" disabled selected>Pilih Jenis Hewan</option>
                                        <option name="jenishewan" id="jenishewan" value="Anjing">Anjing</option>
                                        <option name="jenishewan" id="jenishewan" value="Kucing">Kucing</option>
                                        <option name="jenishewan" id="jenishewan" value="Kelinci">Kelinci</option>
                                        <option name="jenishewan" id="jenishewan" value="Burung">Burung</option>
                                        <option name="jenishewan" id="jenishewan" value="Hamster">Hamster</option>
                                        <option name="jenishewan" id="jenishewan" value="Ayam">Ayam</option>
                                    </select>
                                </div>
                                <!-- Form Group (Ras)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="ras">Ras Hewan <span class="text-danger">*</span></label>
                                    <input class="form-control" id="ras" name="ras" type="text" value="" placeholder="Masukkan Ras Hewan" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5">
                                <!-- Form Group (Jenis Kelamin)-->
                                <div class="col-md-6 5 mb-3">
                                    <label class="small mb-1" for="jeniskelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option name="jeniskelamin" id="jeniskelamin" value="Laki-Laki">Laki-Laki</option>
                                        <option name="jeniskelamin" id="jeniskelamin" value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <!-- Form Group (Berat Hewan)-->
                                <div class="col-md-6 5 mb-3">
                                    <label class="small mb-1" for="berat">Berat Hewan (kg) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="berat" name="berat" type="number" placeholder="Masukkan Berat Hewan" value="" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5">
                                <!-- Form Group (Umur Tahun)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="umur_tahun">Umur Hewan (Tahun) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="umur_tahun" name="umur_tahun" type="number" max="25" placeholder="Masukkan Umur Tahun Hewan" value="" required>
                                </div>
                                <!-- Form Group (Umur Bulan)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="umur_bulan">Umur Hewan (Bulan) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="umur_bulan" name="umur_bulan" type="number" max="11" placeholder="Masukkan Umur Bulan Hewan" value="" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5">
                                <!-- Form Group (Tipe Darah)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="tipedarah">Tipe Darah</label>
                                    <input class="form-control" id="tipedarah" name="tipedarah" type="text" placeholder="Masukkan Tipe Darah" value="">
                                </div>
                                <!-- Form Group (Alergi)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="alergi">Alergi</label>
                                    <input class="form-control" id="alergi" name="alergi" type="text" placeholder="Masukan Alergi" value="">
                                </div>
                            </div>
                            <!-- Form Group (Upload Gambar)-->
                            <div class="row gx-5">
                                <div class="col-md-4  mb-3">
                                    <label class="small mb-1" for="image">Unggah Gambar</label>
                                    <input class="form-control" id="image" name="image" type="file">
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Menambahkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection