<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\JadwalKlinik;

class UpdateJadwalStatus extends Command
{
    protected $signature = 'update:jadwal_status';
    protected $description = 'Update status of jadwal_klinik based on tanggal';

    public function handle()
    {
        $now = Carbon::now()->tz('Asia/Jakarta');

        // Get jadwals where the tanggal is beyond the current date
        $jadwalsToUpdate = JadwalKlinik::where(function ($query) use ($now) {
            $query->where('tanggal', '<', $now->toDateString())
                ->orWhere(function ($subquery) use ($now) {
                    $subquery->where('tanggal', $now->toDateString())
                        ->where('jam_mulai', '<=', $now->format('H:i:s'));
                });
        })
        ->where('status', '=', 'Aktif')
        ->get();

        foreach ($jadwalsToUpdate as $jadwal) {
            // Update status to "Nonaktif"
            $jadwal->update(['status' => 'Nonaktif']);
        }

        $this->info('Scheduled task update:jadwal_status has been executed successfully.');
    }
}
