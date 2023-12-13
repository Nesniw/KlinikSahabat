<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('gambar/Logo Klinik Sahabat Hewan Clear.png') }}">

    <title>Dashboard - Klinik Sahabat Hewan</title>

    <!-- CSS bootstrap yang dipake -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Custom fonts dan dan asset css fontawesome -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom Admin CSS -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-text mx-3">Klinik Sahabat Hewan</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('adminDashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data Admin
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Jadwal Layanan</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Data Klinik</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data:</h6>
                        <a class="collapse-item" href="{{ route('ShowUserData') }}">Data User</a>
                        <a class="collapse-item" href="utilities-color.html">Data Pasien</a>
                        <a class="collapse-item" href="utilities-border.html">Data Transaksi</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $pekerja->namapekerja }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('storage/'.$pekerja->foto) }}" alt="Foto Pekerja">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid ">

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
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('pekerja.logout') }}">
                        @csrf
                        <button class="btn btn-danger" type="submit">Logout</button>
                    </form>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

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

</body>

</html>