@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class="mt-4 mx-4 text-gray-800">Konfirmasi Proses Grooming</h2>
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
        <table class="table table-bordered text-center " style="border-width:2px;">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Layanan</th>
                    <th>Hewan</th>
                    
                    <th>Tanggal Grooming</th>
                    <th>Waktu Grooming</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($transaksi->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada layanan grooming yang sedang di proses</td>
                    </tr>
                @else
                    @foreach ($transaksi as $transaction)
                        <tr>
                            <td>{{ $transaction->transaksi_id }}</td>
                            <td>{{ $transaction->layanan->nama_layanan }}</td>
                            <td>{{ $transaction->pets->namapasien }} ({{ $transaction->pets->ras }}) - {{ $transaction->pets->jeniskelamin }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->waktu)->format('H:i') }} WIB</td>
                            <td>
                                <form method="POST" action="{{route('KonfirmasiSelesaiGrooming', $transaction->transaksi_id)}}">
                                    @csrf
                                    @method('PATCH') 
                                    <button class="btn btn-success" type="submit" name="konfirmasi">Konfirmasi Selesai</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>   

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