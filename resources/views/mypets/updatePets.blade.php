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
                    <div class="card-header d-flex justify-content-around">
                        <h5 class="my-auto">Ubah Data Pet</h5>
                        @if ($pet->status == 'Aktif')
                            <button class="btn btn-danger btn-sm" type="button" id="nonaktifButton">Nonaktifkan</button>
                        @elseif ($pet->status == 'Nonaktif')
                            <form method="POST" action="{{ route('AktifkanPet', $pet->kode_pasien) }}">
                                @csrf
                                <button class="btn btn-success btn-sm" type="submit">Aktifkan</button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body px-5">
                        <form method="POST" action="{{ route('update_pet', $pet->kode_pasien) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row gx-5">
                                <!-- Form Group (Kode Pasien)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="kode_pasien">Kode Pasien</label>
                                    <input class="form-control" id="kode_pasien" name="kode_pasien" type="text" value="{{ old('kode_pasien', $pet->kode_pasien) }}" readonly>
                                </div>
                                <!-- Form Group (Nama Pasien)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="namapasien">Nama Pasien <span class="text-danger">*</span></label>
                                    <input class="form-control" id="namapasien" name="namapasien" type="text" value="{{ old('namapasien', $pet->namapasien) }}" placeholder="Masukkan Nama Pasien" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5">
                                <!-- Form Group (Jenis Hewan)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="jenishewan">Jenis hewan <span class="text-danger">*</span></label>
                                    <select name="jenishewan" class="form-control form-select" id="jenishewan" required>
                                        <option name="jenishewan" id="jenishewan" value="Anjing" @if(old('jenishewan', $pet->jenishewan) === 'Anjing') selected @endif>Anjing</option>
                                        <option name="jenishewan" id="jenishewan" value="Kucing" @if(old('jenishewan', $pet->jenishewan) === 'Kucing') selected @endif>Kucing</option>
                                        <option name="jenishewan" id="jenishewan" value="Kelinci" @if(old('jenishewan', $pet->jenishewan) === 'Kelinci') selected @endif>Kelinci</option>
                                        <option name="jenishewan" id="jenishewan" value="Burung" @if(old('jenishewan', $pet->jenishewan) === 'Burung') selected @endif>Burung</option>
                                        <option name="jenishewan" id="jenishewan" value="Hamster" @if(old('jenishewan', $pet->jenishewan) === 'Hamster') selected @endif>Hamster</option>
                                        <option name="jenishewan" id="jenishewan" value="Ayam" @if(old('jenishewan', $pet->jenishewan) === 'Ayam') selected @endif>Ayam</option>
                                    </select>
                                </div>
                                <!-- Form Group (Ras)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="ras">Ras Hewan <span class="text-danger">*</span></label>
                                    <input class="form-control" id="ras" name="ras" type="text" value="{{ old('ras', $pet->ras) }}" placeholder="Masukkan Ras Hewan" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5">
                                <!-- Form Group (Jenis Kelamin)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="jeniskelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option name="jeniskelamin" id="jeniskelamin" value="Laki-Laki" @if(old('jeniskelamin', $pet->jeniskelamin) === 'Laki-Laki') selected @endif>Laki-Laki</option>
                                        <option name="jeniskelamin" id="jeniskelamin" value="Perempuan" @if(old('jeniskelamin', $pet->jeniskelamin) === 'Perempuan') selected @endif>Perempuan</option>
                                    </select>
                                </div>
                                <!-- Form Group (Berat Hewan)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="berat">Berat Hewan (kg) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="berat" name="berat" type="number" placeholder="Masukkan Berat Hewan" value="{{ old('berat', $pet->berat) }}" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5">
                                <!-- Form Group (Umur Tahun)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="umur_tahun">Umur Hewan (Tahun) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="umur_tahun" name="umur_tahun" type="number" max="25" placeholder="Masukkan Umur Tahun Hewan" value="{{ old('umur_tahun', $pet->umur_tahun) }}" required>
                                </div>
                                <!-- Form Group (Umur Bulan)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="umur_bulan">Umur Hewan (Bulan) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="umur_bulan" name="umur_bulan" type="number" max="11" placeholder="Masukkan Umur Bulan Hewan" value="{{ old('umur_bulan', $pet->umur_bulan) }}" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5">
                                <!-- Form Group (Tipe Darah)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="tipedarah">Tipe Darah</label>
                                    <input class="form-control" id="tipedarah" name="tipedarah" type="text" placeholder="Masukkan Tipe Darah" value="{{ old('tipedarah', $pet->tipedarah) }}">
                                </div>
                                <!-- Form Group (Alergi)-->
                                <div class="col-md-6  mb-3">
                                    <label class="small mb-1" for="alergi">Alergi</label>
                                    <input class="form-control" id="alergi" name="alergi" type="text" placeholder="Masukan Alergi" value="{{ old('alergi', $pet->alergi) }}">
                                </div>
                            </div>
                            <!-- Form Group (Upload Gambar)-->
                            <div class="row gx-5">
                                <div class="col-md-4  mb-3">
                                    <label class="small mb-1" for="image">Unggah Gambar</label>
                                    <input class="form-control" id="image" name="image" type="file">
                                    @if($pet->image)
                                        <img src="{{ asset('storage/'.$pet->image) }}" alt="Pet Image" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                                    @endif
                                    <input type="hidden" name="old_image" value="{{ $pet->image }}">
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
    
    <!-- Modal untuk nonaktifkan -->
    <div class="modal fade" id="nonaktifModal" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="nonaktifModalLabel">Alasan Nonaktif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('NonaktifkanPet', $pet->kode_pasien) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="text-secondary" for="alasan_nonaktif">Masukkan alasan nonaktif:</label>
                            <textarea class="form-control" id="alasan_nonaktif" name="alasan_nonaktif" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Nonaktifkan Pet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-..." crossorigin="anonymous"></script>

    <script>
        // JavaScript to show modal when nonaktifButton is clicked
        document.getElementById('nonaktifButton').addEventListener('click', function () {
            var myModal = new bootstrap.Modal(document.getElementById('nonaktifModal'));
            myModal.show();
        });
    </script>


@endsection