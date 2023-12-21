@extends('layouts.admin-master')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h2 class="mt-4 mx-4 text-gray-800">Konfirmasi Pembayaran</h2>
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
                <th>Customer</th>
                <th>Bukti Transfer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($transaksi->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pembayaran yang perlu dikonfirmasi</td>
                </tr>
            @else
                @foreach ($transaksi as $transaction)
                    <tr>
                        <td>{{ $transaction->transaksi_id }}</td>
                        <td>{{ $transaction->user->namalengkap }}</td>
                        <td>
                            @if ($transaction->bukti_transfer)
                                <img src="{{ asset('storage/' . $transaction->bukti_transfer) }}" width="300px" height="200px" alt="Bukti Transfer">
                                <!-- Tambahkan link download -->
                                <br><a class="btn btn-primary my-2" href="{{ route('DownloadBuktiPembayaran', ['transaksi_id' => $transaction->transaksi_id]) }}" download>Download Bukti</a>
                            @else
                                <p class="text-center text-danger">Belum ada bukti pembayaran</p>
                            @endif
                        </td>
                        <td>
                            <form method="post" action="{{ route('KonfirmasiPembayaran', $transaction) }}">
                                @csrf
                                <button class="btn btn-success" type="submit" name="approve">Approve</button>
                                <button class="btn btn-danger" type="submit" name="reject">Reject</button>
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