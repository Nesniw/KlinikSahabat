@extends('layouts.admin-master')

@section('content')

    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('failed'))
            <div class="alert alert-danger alert-dismissible fade show " role="alert">
                {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
    </div>

    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="row gx-3">
            <!-- Account card-->
            <div class="col-md-12">
                <div class="card m-4">
                    <div class="card-header"><h3>Informasi Akun</h3>
                        <div class="d-flex align-items-center"></div>
                    </div>
                    <div class="card-body">
                        <div class="row gx-5 mb-4">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/'.$pekerja->foto) }}" alt="Foto Pekerja" width="200px" height="260px">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <form method="POST" action="{{ route('updateProfilePekerja') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="row gx-5 mb-4">
                                        <!-- Form Group (Nama Lengkap)-->
                                        <div class="col-md-6">
                                            <label class="medium mb-1" for="namapekerja">Nama Pekerja <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="namapekerja" name="namapekerja" value="{{ old('namapekerja', $pekerja->namapekerja) }}" required>
                                        </div>
                                        <!-- Form Group (Jenis Kelamin)-->
                                        <div class="col-md-6">
                                            <label class="medium mb-1" for="jeniskelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin">
                                                <option value="Pria" @if(old('jeniskelamin', $pekerja->jeniskelamin) === 'Pria') selected @endif>Pria</option>
                                                <option value="Wanita" @if(old('jeniskelamin', $pekerja->jeniskelamin) === 'Wanita') selected @endif>Wanita</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-5 mb-4">
                                        <!-- Form Group (Tanggal Lahir)-->
                                        <div class="col-md-6">
                                            <label class="medium mb-1" for="tanggallahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggallahir" max="{{ date('Y-m-d', strtotime('-12 years')) }}" name="tanggallahir" value="{{ old('tanggallahir', $pekerja->tanggallahir) }}" required>
                                        </div>
                                        <!-- Form Group (Roles)-->
                                        <div class="col-md-6">
                                            <label class="medium mb-1" for="peran">Peran <span class="text-danger">*</span></label>
                                            <select name="peran" class="form-control form-select" id="peran">
                                                <option value="Admin" @if(old('peran', $pekerja->peran) === 'Admin') selected @endif>Admin</option>
                                                <option value="Dokter" @if(old('peran', $pekerja->peran) === 'Dokter') selected @endif>Dokter</option>
                                                <option value="Groomer" @if(old('peran', $pekerja->peran) === 'Groomer') selected @endif>Groomer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-5 mb-4">
                                        <!-- Form Group (Email)-->
                                        <div class="col-md-6">
                                            <label class="medium mb-1" for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" pattern="[a-zA-Z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" name="email" value="{{ old('email', $pekerja->email) }}" required>
                                        </div>
                                        <!-- Form Group (Nomor Telepon)-->
                                        <div class="col-md-6">
                                            <label class="medium mb-1" for="nomortelepon">Nomor Telepon <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="nomortelepon" name="nomortelepon" value="{{ old('nomortelepon', $pekerja->nomortelepon) }}" required>
                                        </div>
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-5 mb-4">
                                        <!-- Form Group (Alamat)-->
                                        <div class="col-md-12">
                                            <label class="medium mb-1" for="alamat">Alamat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $pekerja->alamat) }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row gx-5 mb-3">
                                        <div class="col-md-4">
                                            <label class="small mb-1" for="foto">Unggah Gambar</label>
                                            <input class="form-control" id="foto" name="foto" type="file">
                                            <input type="hidden" name="old_foto" value="{{ $pekerja->foto }}">
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

    <script>
        $(document).ready(function() {
            // Close alert after 10 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 10000);

            // Close alert when close button is clicked
            $('.alert .btn-close').on('click', function() {
                $(this).closest('.alert').alert('close');
            });
        });
    </script>

@endsection