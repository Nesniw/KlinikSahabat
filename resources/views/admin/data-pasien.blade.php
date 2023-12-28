@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class=" mb-0 text-gray-800">Data Pasien - Klinik Sahabat Hewan</h2>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>


    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="container-fluid bg-white shadow p-3 mb-5 bg-white rounded">
        <table class="table table-bordered data-table">
            <thead>
                <tr> 
                    <th>Kode Pasien</th>
                    <th>Nama Pasien</th>
                    <th>Nama Pemilik</th>
                    <th>Jenis Hewan</th>
                    <th>Ras</th>
                    <th>Jenis Kelamin</th>
                    <th>Umur (Tahun)</th>
                    <th>Umur (Bulan)</th>
                    <th>Berat</th>
                    <th>Tipe Darah</th>
                    <th>Alergi</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>              
  
    <script type="text/javascript">
        $(function () {
            
            var table = $('.data-table').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('ShowPasienData') }}",
                columns: [
                    { data: 'kode_pasien', name: 'kode_pasien' },
                    { data: 'namapasien', name: 'namapasien' },
                    { data: 'nama_pemilik', name: 'nama_pemilik' },
                    { data: 'jenishewan', name: 'jenishewan' },
                    { data: 'ras', name: 'ras' },
                    { data: 'jeniskelamin', name: 'jeniskelamin' },
                    { data: 'umur_tahun', name: 'umur_tahun' },
                    { data: 'umur_bulan', name: 'umur_bulan' },
                    { data: 'berat', name: 'berat' },
                    { data: 'tipedarah', name: 'tipedarah' },
                    { data: 'alergi', name: 'alergi' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                ],
                language: {
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "search": "Pencarian:",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    "infoFiltered": "(difilter dari total _MAX_ data)",
                    "oAria": {
                        "sSortAscending": ": activate to sort column ascending",
                        "sSortDescending": ": activate to sort column descending"
                    },
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Berikutnya",
                    }
                }
            });
            
        });
    </script>

    <script>
        $(document).ready(function () {
            // Tangkap klik tombol delete dan submit formulir
            $('.data-table').on('click', '.delete', function () {
                $(this).closest('form').submit();
            });
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