@extends('layouts.admin-master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class="mt-4 mx-4 text-gray-800">Jadwal Aktif Dokter</h2>
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
                    <th>Layanan</th>
                    <th>Customer</th>
                    <th>Hewan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Keterangan dan Medikasi</th>
                </tr>
            </thead>
            <tbody>
                @if($transaksi->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada jadwal layanan yang sedang aktif</td>
                    </tr>
                @else
                    @foreach ($transaksi as $transaction)
                        <tr>
                            <td>{{ $transaction->layanan->nama_layanan }}</td>
                            <td>{{ $transaction->user->namalengkap }}</td>
                            <td>{{ $transaction->pets->jenishewan }} ({{ $transaction->pets->ras }}) - {{ $transaction->pets->jeniskelamin }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->JadwalKlinik->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->JadwalKlinik->jam_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($transaction->JadwalKlinik->jam_selesai)->format('H:i') }} WIB</td>
                            <td>    
                            @if($transaction->rekamMedis)
                                <a href="{{ route ('TambahKeteranganDanMedikasi', $transaction->transaksi_id) }}" class="btn btn-success">
                                    Update Keterangan
                                </a>
                            @else
                                <a href="{{ route ('TambahKeteranganDanMedikasi', $transaction->transaksi_id) }}" class="btn btn-primary">
                                    Tambah Keterangan
                                </a>
                            @endif
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