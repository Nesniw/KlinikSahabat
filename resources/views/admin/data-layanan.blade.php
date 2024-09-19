@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class=" mb-0 text-gray-800">Data Layanan - Klinik Sahabat Hewan</h2>
    </div>

    <a href="{{ route('CreateLayananForm') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3">
        <i class="fa fa-plus fa-sm color-white"></i> Tambah Layanan
    </a>

    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="container-fluid bg-white shadow p-3 mb-5 rounded">
        <table class="table table-bordered data-table">
            <thead>
                <tr> 
                    <th>Layanan Id</th>
                    <th>Nama Layanan</th>
                    <th>Kategori</th>
                    <th>Biaya Booking</th>
                    <th>Harga Layanan</th>
                    <th>Deskripsi</th>
                    <th>Action</th>
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
                serverSide: false,
                searching: true,
                searchDelay: 500,
                ajax: "{{ route('ShowLayananData') }}",
                columns: [
                    { data: 'layanan_id', name: 'layanan_id'},
                    { data: 'nama_layanan', name: 'nama_layanan'},
                    { data: 'kategori_layanan', name: 'kategori_layanan'},
                    { 
                        data: 'biaya_booking', name: 'biaya_booking',
                        render: function (data, type, row) {
                            return 'Rp ' + new Intl.NumberFormat().format(data);
                        }
                    },
                    { 
                        data: 'harga_layanan', name: 'harga_layanan',
                        render: function (data, type, row) {
                            return 'Rp ' + new Intl.NumberFormat().format(data);
                        }
                    },
                    { data: 'deskripsi_layanan', name: 'deskripsi_layanan'},
                    { data: 'action', name: 'action', orderable: false, searchable: false},
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

@endsection