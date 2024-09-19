@extends('layouts.admin-master')

@section('content')

    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
        <div class="row gx-3">
            <!-- Account card-->
            <div class="col-md-12">
                <div class="card m-4">
                    <div class="card-header"><h3>Detail Informasi Pekerja</h3></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route ('UpdatePekerjaData', ['pekerja_id' => $pekerja->pekerja_id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Nama Lengkap)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="namapekerja">Nama Pekerja <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="namapekerja" name="namapekerja" value="{{ old('namapekerja', $pekerja->namapekerja) }}" readonly>
                                </div>
                                <!-- Form Group (ID Pekerja)-->
                                <div class="col-md-3">
                                    <label class="medium mb-1" for="pekerja_id">ID Pekerja <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pekerja_id" name="pekerja_id" value="{{ old('pekerja_id', $pekerja->pekerja_id) }}" readonly>
                                </div>
                                <!-- Form Group (Peran)-->
                                <div class="col-md-3">
                                    <label class="medium mb-1" for="peran">Peran Pekerja <span class="text-danger">*</span></label>
                                    <select name="peran" class="form-control form-select" id="peran" readonly>
                                        @if ($pekerja->peran === 'Admin')
                                            <option value="Admin" @if(old('peran', $pekerja->peran) === 'Admin') selected @endif>Admin</option>
                                        @else
                                            <option value="Dokter" @if(old('peran', $pekerja->peran) === 'Dokter') selected @endif>Dokter</option>
                                            <option value="Groomer" @if(old('peran', $pekerja->peran) === 'Groomer') selected @endif>Groomer</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Jenis Kelamin)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="jeniskelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin" readonly>
                                        <option value="Pria" @if(old('jeniskelamin', $pekerja->jeniskelamin) === 'Pria') selected @endif>Pria</option>
                                        <option value="Wanita" @if(old('jeniskelamin', $pekerja->jeniskelamin) === 'Wanita') selected @endif>Wanita</option>
                                    </select>
                                </div>
                                <!-- Form Group (Tanggal Lahir)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="tanggallahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggallahir" max="{{ date('Y-m-d', strtotime('-12 years')) }}" name="tanggallahir" value="{{ old('tanggallahir', $pekerja->tanggallahir) }}" readonly>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Email)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" pattern="[a-zA-Z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" name="email" value="{{ old('email', $pekerja->email) }}" readonly>
                                </div>
                                <!-- Form Group (Nomor Telepon)-->
                                <div class="col-md-6">
                                    <label class="medium mb-1" for="nomortelepon">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="nomortelepon" name="nomortelepon" value="{{ old('nomortelepon', $pekerja->nomortelepon) }}" readonly>
                                </div>
                            </div>
                            <div class="row gx-5 mb-4">
                                <!-- Form Group (Alamat)-->
                                <div class="col-md-8">
                                    <label class="medium mb-1" for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $pekerja->alamat) }}" readonly>
                                </div>
                                <!-- Form Group (Upload Gambar)-->
                                <div class="col-md-4">
                                    <label class="medium mb-1" for="foto">Foto</label><br>
                                    <!-- <input class="form-control" id="foto" name="foto" type="file"> -->
                                    @if($pekerja->foto)
                                        <img src="{{ asset('storage/'.$pekerja->foto) }}" alt="Foto Pekerja" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                                    @endif
                                    <!-- <input type="hidden" name="old_foto" value="{{ $pekerja->foto }}"> -->
                                </div>
                            </div>

                            <!-- Save changes button-->
                            <!-- <button class="btn btn-primary" type="submit">Update</button> -->
                            <a href="{{route('ShowPekerjaData')}}" class="btn btn-primary">Kembali</a>
                        </form>
                        <form method="POST" action="{{ route('NonaktifPekerja', $pekerja->pekerja_id) }}" class="float-end">
                            @csrf
                            @method('PATCH') 
                            
                            @if ($pekerja->peran !== 'Admin')
                            <button class="btn btn-{{ $pekerja->status === 'Aktif' ? 'danger' : 'success' }}" type="submit">
                                {{ $pekerja->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                            @endif

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
