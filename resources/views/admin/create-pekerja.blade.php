@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mt-2 mb-4">
        <h1 class="mb-0 text-gray-500">Tambah Akun Pekerja</h1>
    </div>

    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="card">
            <div class="card-header"><h6>Isi form dibawah ini untuk membuat akun pekerja baru</h6></div>
            <div class="card-body px-5">
                <form method="POST" action="{{ Route ('CreatePekerjaData') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row gx-5 mb-3">
                        <!-- Form Group (Nama Pekerja)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="namapekerja">Nama Pekerja <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="namapekerja" name="namapekerja" value="" required>
                        </div>
                    </div>
                    <div class="row gx-5 mb-3">
                        <!-- Form Group (Peran)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="peran">Peran <span class="text-danger">*</span></label>
                            <select name="peran" class="form-control form-select" id="peran" required>
                                <option value="" disabled selected>Pilih Peran Pekerja</option>
                                <option name="peran" id="peran" value="Dokter">Dokter</option>
                                <option name="peran" id="peran" value="Groomer">Groomer</option>
                            </select>
                        </div>
                        <!-- Form Group (Jenis Kelamin)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="jeniskelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option name="jeniskelamin" id="jeniskelamin" value="Pria">Pria</option>
                                <option name="jeniskelamin" id="jeniskelamin" value="Wanita">Wanita</option>
                            </select>
                        </div>
                    </div>
                    <!-- Form Row-->
                    <div class="row gx-5 mb-3">
                        <!-- Form Group (Tanggal Lahir)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="tanggallahir">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggallahir" max="{{ date('Y-m-d', strtotime('-12 years')) }}" name="tanggallahir" value="" required>
                        </div>
                        <!-- Form Group (Roles)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="alamat">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="" required>
                        </div>
                    </div>
                    <!-- Form Row-->
                    <div class="row gx-5 mb-3">
                        <!-- Form Group (Email)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" pattern="[a-zA-Z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" name="email" value="" required>
                        </div>
                        <!-- Form Group (Nomor Telepon)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="nomortelepon">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nomortelepon" name="nomortelepon" value="" required>
                        </div>
                    </div>

                    <!-- Form Row-->
                    <div class="row gx-5 mb-3">
                        <!-- Form Group (Password)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8" value="" required>
                        </div>
                        <!-- Form Group (Confirm Password)-->
                        <div class="col-md-6">
                            <label class="medium mb-1" for="confpassword">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confpassword" name="confpassword" value="" required>
                        </div>
                    </div>
                    <!-- Form Group (Upload Gambar)-->
                    <div class="row gx-5 mb-4">
                        <div class="col-md-4">
                            <label class="small mb-1" for="foto">Unggah Gambar</label>
                            <input class="form-control" id="foto" name="foto" type="file">
                        </div>
                    </div>
        
                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">Tambah</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascript code buat konfirmasi password  -->
    <script>
        var password = document.getElementById("password"); 
        var confirm_password = document.getElementById("confpassword");

        function validatePassword(){
            if(password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Password tidak cocok");
            } 
            else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;    
    </script>

    <!-- Javascript code buat limit nomor telepon  -->
    <script>
        document.getElementById('nomortelepon').addEventListener('input', function () {
            if (this.value.length > 14) {
                this.setCustomValidity('Nomor telepon maksimal 14 digit');
            }
            else if (this.value.length < 12) {
                this.setCustomValidity('Nomor telepon minimal 12 digit');
            }
            else {
                this.setCustomValidity('');
            }
        });
    </script>

@endsection
