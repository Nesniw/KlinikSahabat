@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class="mt-4 mx-4 text-gray-800">Konfirmasi Pembayaran</h2>
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
        <table class="table table-bordered text-center" style="border-width:2px;">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Customer</th>
                    <th>Total Biaya</th>
                    <th>Bukti Transfer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($transaksi->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada pembayaran yang perlu dikonfirmasi</td>
                    </tr>
                @else
                    @foreach ($transaksi as $key => $transaction)
                        <tr>
                            <td>{{ $transaction->transaksi_id }}</td>
                            <td>{{ $transaction->user->namalengkap }}</td>
                            <td>Rp {{ $transaction->total_biaya }}</td>
                            <td>
                                @if ($transaction->bukti_transfer)
                                    <a href="{{ asset('storage/' . $transaction->bukti_transfer) }}" data-toggle="modal" data-target="#buktiTransferModal{{ $key }}">
                                        <img src="{{ asset('storage/' . $transaction->bukti_transfer) }}"  width="300px" height="200px" alt="Bukti Transfer">
                                    </a>

                                    <!-- Tambahkan link download -->
                                    <br><a class="btn btn-primary my-2" href="{{ route('DownloadBuktiPembayaran', ['transaksi_id' => $transaction->transaksi_id]) }}" download>Download Bukti</a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="buktiTransferModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="buktiTransferModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="buktiTransferModalLabel">Bukti Transfer</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $transaction->bukti_transfer) }}" class="img-fluid" alt="Bukti Transfer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center text-danger">Belum ada bukti pembayaran</p>
                                @endif
                            </td>
                            <td>
                                <!-- Formulir untuk Approve -->
                                <form method="post" action="{{ route('KonfirmasiPembayaran', $transaction) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success" type="submit" name="approve">Approve</button>
                                </form>

                                <!-- Formulir untuk Reject -->
                                <form method="post" action="{{ route('KonfirmasiPembayaran', $transaction) }}" class="d-inline">
                                    @csrf
                                    <!-- Tambahkan tombol untuk menampilkan modal reject -->
                                    <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#rejectModal{{ $key }}">Reject</button>

                                    <!-- Modal untuk Reject -->
                                    <div class="modal fade" id="rejectModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel">Reject Payment</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Formulir untuk alasan reject -->
                                                    <form method="post" action="{{ route('KonfirmasiPembayaran', $transaction) }}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="rejectReason">Alasan Reject</label>
                                                            <textarea class="form-control" id="rejectReason" name="rejectReason" rows="3" required></textarea>
                                                        </div>
                                                        <button class="btn btn-danger" type="submit" name="reject">Submit Reject</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

<script>
    $(document).ready(function() {
        // Menanggapi penutupan modal reject
        $('.modal').on('hidden.bs.modal', function () {
            // Mengosongkan kolom alasan reject
            $('textarea[name="rejectReason"]').val('');
        });

        // Close alert setelah 10 detik
        setTimeout(function() {
            $('.alert').alert('close');
        }, 10000);

        // Menanggapi penutupan alert ketika tombol close diklik
        $('.alert .btn-close').on('click', function() {
            $(this).closest('.alert').alert('close');
        });
    });
</script>

@endsection