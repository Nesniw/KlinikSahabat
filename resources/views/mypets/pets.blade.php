@extends('layouts.master')

@section('content')

    <div class="custom-container px-4 mt-4">
        <div class="alert-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show " role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
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
                    <div class="card-header"><h5>My Pets</h5></div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <form method="GET" action="{{ route('registerPets') }}">
                                @csrf
                                <button class="btn btn-warning" type="submit">Tambah Pet <i class="fa-solid fa-plus"></i></button>
                            </form>
                        </div>
                        <hr class="mt-4 mb-3">
                        <div class="row gx-4 gy-3 mb-3">
                        @forelse ($userPets as $pet)
                            <div class="col-md-5">
                                <img class="pets-image-container" src="{{ asset($pet->image ? 'storage/' . $pet->image : 'gambar/Anons.png') }}" alt="Gambar Hewan">
                            </div>
                            <div class="col-md-7">
                                <h2 class="text-warning text-center">{{ $pet->namapasien }}</h2>
                                <hr class="mt-2 mb-2">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Animal Type</td>
                                            <td>{{ $pet->jenishewan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Breed</td>
                                            <td>{{ $pet->ras }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>{{ $pet->jeniskelamin }}</td>
                                        </tr>
                                        <tr>
                                            <td>Age</td>
                                            <td>{{ $pet->umur_tahun }} Tahun {{ $pet->umur_bulan }} Bulan</td>
                                        </tr>
                                        <tr>
                                            <td>Weight</td>
                                            <td>{{ $pet->berat }} kg</td>
                                        </tr>
                                        @if ($pet->status == 'Nonaktif')
                                        <tr class="text-danger">
                                            <td >Status</td>
                                            <td>{{ $pet->alasan_nonaktif }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row gx-4 gy-3 mb-3">
                                    <div class="text-center">

                                        @if ($pet->RekamMedis->count() > 0)
                                            <a href="{{ route('ShowRekamMedis', $pet->kode_pasien) }}" class="btn btn-success mx-3">Rekam Medis</a>
                                        @endif
                                    
                                        <form method="GET" action="{{ route('updatePetForms', $pet->kode_pasien) }}" class="d-inline">
                                            @csrf
                                            <button class="btn btn-primary" type="submit">Ubah</button>
                                        </form>
                                        @if ($pet->Transaksi->count() == 0)
                                        <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#deletemodal_{{ $pet->kode_pasien }}">
                                            Hapus
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Konfirmasi Delete -->
                            <div class="modal fade" id="deletemodal_{{ $pet->kode_pasien }}" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deletemodalLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-danger">
                                            Apakah Anda yakin ingin menghapus hewan peliharaan ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form method="POST" action="{{ route('delete_pet', $pet->kode_pasien) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <hr class="mt-4 mb-3">
                        @empty
                            <h5 class="text-center text-danger mt-5">Anda belum mendaftarkan peliharaan.</h5>
                        @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!--Bootstrap Script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kGQDBBC11VcCY5u3b5CeZGxWUcXRDFVN+w4dd5Sh0a6RSg9l/5MdeZrOMbP" crossorigin="anonymous"></script>

    <!-- Skrip untuk menampilkan modal -->
    <script>
        $(document).ready(function () {
            // Event click pada tombol Delete untuk menampilkan modal
            $('.btn-delete').click(function () {
                // Dapatkan data-target dari tombol Delete yang diklik
                var targetModalId = $(this).data('target');
                // Tampilkan modal yang sesuai dengan data-target
                $(targetModalId).modal('show');
            });
        });
    </script>

    <!-- Script untuk matiin auto dan manual alert -->
    <script>
        $(document).ready(function() {
            // Close alert after 10 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 10000);

            // Close alert when close button is clicked
            $('.alert .btn-close').on('click', function() {
                $(this).closest('.alert').fadeOut();
            });
        });
    </script>

@endsection