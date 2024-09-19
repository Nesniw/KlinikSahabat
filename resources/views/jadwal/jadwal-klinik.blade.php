@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class=" mb-0 text-gray-800">Jadwal Layanan - Klinik Sahabat Hewan</h2>
    </div>

    <a href="{{ route('CreateJadwalForm') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3">
        <i class="fa fa-plus fa-sm color-white"></i> Tambah Jadwal
    </a>

    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="alert-container">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show " role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="container-fluid bg-white shadow p-3 mb-5 rounded">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Jadwal ID</th>
                    <th>Layanan</th>
                    <th>Pekerja</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
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
                ajax: "{{ route('ShowJadwalKlinik') }}",
                columns: [
                    { data: 'jadwal_klinik_id', name: 'jadwal_klinik_id'},
                    { data: 'nama_layanan', name: 'nama_layanan'},
                    { data: 'namapekerja', name: 'namapekerja'},
                    { data: 'tanggal', name: 'tanggal',
                        render: function(data, type, full, meta) {
                            if (type === 'display') {
                                var date = new Date(data);
                                var day = ('0' + date.getDate()).slice(-2);
                                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                                var year = date.getFullYear();
                                return day + '-' + month + '-' + year;
                            }
                            return data;
                        }
                    },
                    { data: 'waktu', name: 'waktu'},
                    { data: 'status', name: 'status'},
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