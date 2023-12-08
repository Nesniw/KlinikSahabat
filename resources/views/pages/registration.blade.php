<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Klinik Sahabat Hewan</title>
    <link rel="shortcut icon" href="{{ asset('gambar/Logo Klinik Sahabat Hewan Clear.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&family=Roboto:wght@500&family=Salsa&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body class="container-registration">
    <div class="trans-container">
        <div class="header-container justify-content-center">
            <a href="/"><img src="gambar/Logo Klinik Sahabat Hewan Clear.png" alt="Logo Klinik" width="50px" height="50px"></a>
            <p>Registrasi <span>Akun</span></p>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row gy-4 gy-xl-4 gx-xl-5 p-4 p-xl-5 justify-content-center">
                <div class="col-10 col-md-5">
                    <label for="fullname" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="" required>
                </div>
                <div class="col-10 col-md-5">
                    <label for="jeniskelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jeniskelamin" class="form-control form-select" id="jeniskelamin" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option name="jeniskelamin" id="jeniskelamin" value="Pria">Pria</option>
                        <option name="jeniskelamin" id="jeniskelamin" value="Wanita">Wanita</option>
                    </select>
                </div>
                <div class="col-10 col-md-5">
                    <label for="tanggallahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tanggallahir" max="{{ date('Y-m-d', strtotime('-7 years')) }}" name="tanggallahir" value="" required>
                    
                </div>
                <div class="col-10 col-md-5">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="" required>
                </div>
                <div class="col-10 col-md-5">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                            </svg>
                        </span>
                        <input type="email" class="form-control" id="email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" name="email" value="" required>
                    </div>
                </div>
                <div class="col-10 col-md-5">
                    <label for="nomortelepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>
                        </span>
                        <input type="number" class="form-control" id="nomortelepon" name="nomortelepon" value="" required>
                    </div>
                </div>
                <div class="col-10 col-md-5">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" class="form-control" id="password" name="password" value="" required>
                    </div>
                </div>
                <div class="col-10 col-md-5">
                    <label for="confpassword" class="form-label">Input Ulang Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" class="form-control" id="confpassword" name="confpassword" value="" required>
                    </div>
                </div>
                <div class="col-10">
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg " type="submit">Buat</button>
                        <hr>
                        <a class="logregLink" href="{{ route('login') }}">Sudah Memiliki Akun? Login</a>
                    </div>
                </div>
            </div>
        </form>
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
</body>
</html>