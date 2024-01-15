@extends('layouts.admin-master')

@section('content')

    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="row gx-3">
            <!-- Account card-->
            <div class="col-md-12">
                <div class="card m-4">
                    <div class="card-header"><h3>Ubah Informasi Akun</h3></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route ('UpdateUserData', ['user_id' => $user->user_id]) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Nama Lengkap)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="namalengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="namalengkap" name="namalengkap" value="{{ old('namalengkap', $user->namalengkap) }}" required>
                                </div>
                                <!-- Form Group (Jenis Kelamin)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="jeniskelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin">
                                        <option value="Pria" @if(old('jeniskelamin', $user->jeniskelamin) === 'Pria') selected @endif>Pria</option>
                                        <option value="Wanita" @if(old('jeniskelamin', $user->jeniskelamin) === 'Wanita') selected @endif>Wanita</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Tanggal Lahir)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="tanggallahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggallahir" max="{{ date('Y-m-d', strtotime('-12 years')) }}" name="tanggallahir" value="{{ old('tanggallahir', $user->tanggallahir) }}" required>
                                </div>
                                <!-- Form Group (Roles)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat) }}" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Email)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" pattern="[a-zA-Z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" name="email" value="{{ old('email', $user->email) }}" readonly>
                                </div>
                                <!-- Form Group (Nomor Telepon)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="nomortelepon">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="nomortelepon" name="nomortelepon" value="{{ old('nomortelepon', $user->nomortelepon) }}" required>
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