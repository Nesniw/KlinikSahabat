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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ Asset('img/undraw_profile.svg') }}">
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
                    <div class="container bg-white shadow p-3 mb-5 bg-white rounded">
                        <div class="row gx-3">
                            <!-- Account card-->
                            <div class="col-md-12">
                                <div class="card m-4">
                                    <div class="card-header"><h3>Tambah Jadwal Pet Clinic dan Grooming</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ Route ('CreateJadwalKlinik') }}">
                                            @csrf
                                            <div class="row gx-5 mb-4">
                                                <!-- Form Group (Nama Layanan)-->
                                                <div class="col-md-6">
                                                    <label class="medium mb-1" for="layanan_id">Nama Layanan <span class="text-danger">*</span></label>
                                                    <select name="layanan_id" class="form-control form-select" id="layanan_id" required>
                                                        <option value="" disabled selected>Pilih Nama Layanan</option>
                                                        @foreach($layanan as $lay)
                                                            <option value="{{ $lay->layanan_id }}">{{ $lay->kategoriLayanan->nama_kategori }} - {{ $lay->nama_layanan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!-- Form Group (Pekerja ID)-->
                                                <div class="col-md-6">
                                                    <label class="medium mb-1" for="pekerja_id">Nama Pekerja <span class="text-danger">*</span></label>
                                                    <select name="pekerja_id" class="form-control form-select" id="pekerja_id" required>
                                                        <option value="" disabled selected>Pilih Nama Pekerja</option>
                                                        @foreach($pekerja as $pk)
                                                            @if($pk->peran == 'Dokter' || $pk->peran == 'Groomer')
                                                                <option value="{{ $pk->pekerja_id }}">{{ $pk->namapekerja }} ({{ $pk->peran }})</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row gx-5 mb-4">
                                                <!-- Form Group (Tanggal)-->
                                                <div class="col-md-6">
                                                    <label class="medium mb-1" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                                                </div>
                                                <!-- Form Group (Jam Mulai)-->
                                                <div class="col-md-3">
                                                    <label class="medium mb-1" for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" min="09:00" max="16:59" required>
                                                </div>
                                                <!-- Form Group (Jam Selesai)-->
                                                <div class="col-md-3">
                                                    <label class="medium mb-1" for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" min="09:00" max="16:59" required>
                                                </div>
                                            </div>
                                            <div class="row gx-5 mb-4">
                                                <!-- Form Group (Status)-->
                                                <div class="col-md-6">
                                                    <label class="medium mb-1" for="status">Status <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-control form-select" id="status" required>
                                                        <option value="" disabled selected>Pilih Status</option>
                                                        <option value="Aktif">Aktif</option>
                                                        <option value="Dipesan">Dipesan</option>
                                                        <option value="Nonaktif">Nonaktif</option>
                                                        <option value="Selesai">Selesai</option>
                                                    </select>
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
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
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

    

</body>

</html>