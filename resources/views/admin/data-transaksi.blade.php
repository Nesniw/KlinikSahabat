@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class=" mb-0 text-gray-800">Data Transaksi - Klinik Sahabat Hewan</h2>
        <a href="{{route('ShowLaporanTransaksi')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Laporan Transaksi
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

    <div class="container-fluid bg-white shadow p-3 mb-5 rounded">
        <table class="table table-bordered data-table">
            <thead>
                <tr> 
                    <th>ID Transaksi</th>
                    <th>Layanan</th>
                    <th>Customer</th>
                    <th>Waktu</th>
                    <th>Total Biaya</th>
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
                ajax: "{{ route('ShowTransaksi') }}",
                columns: [
                    { data: 'transaksi_id', name: 'transaksi_id'},
                    { data: 'nama_layanan', name: 'nama_layanan'},
                    { data: 'namalengkap', name: 'namalengkap'},
                    { data: 'waktu', name: 'waktu'},
                    { data: 'total_biaya', name: 'total_biaya'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    
                ],
                order: [[0, 'desc']],
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

@endsection