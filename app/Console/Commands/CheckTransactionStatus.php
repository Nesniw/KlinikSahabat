<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Transaksi;

class CheckTransactionStatus extends Command
{
    protected $signature = 'check:transaction-status';
    protected $description = 'Check and update transaction status';
    
    public function handle()
    {
        Log::info('Checking transaction status...');

        // Get transactions that are still waiting for payment or have payment failed status
        $transactions = Transaksi::whereIn('status', ['Menunggu Pembayaran', 'Pembayaran Gagal'])->get();

        foreach ($transactions as $transaksi) {
            // Check if the expiration time has passed
            $expirationTime = Carbon::parse($transaksi->waktu_ekspirasi); // Ambil dari field waktu_ekspirasi
            $now = now();

            Log::info("Now: {$now}, Expiration Time: {$expirationTime}");

            if ($now >= $expirationTime) {
                // Update the transaction status to "Expired"
                $transaksi->update(['status' => 'Expired']);

                // Update the status of the associated jadwal_transaksi to "Aktif"
                $jadwal_klinik = $transaksi->JadwalKlinik;
                $jadwal_klinik->update(['status' => 'Aktif']);

                // // Trigger event to notify clients about the expired transaction
                // event(new TransaksiUpdated($transaksi));

                Log::info("Transaction {$transaksi->transaksi_id} has been marked as Expired.");
            }
        }

        Log::info('Transaction status check completed.');
    }
}
