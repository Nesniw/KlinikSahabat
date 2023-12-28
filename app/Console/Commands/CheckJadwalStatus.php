<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JadwalKlinik;
use Carbon\Carbon;

class CheckJadwalStatus extends Command
{
    protected $signature = 'check:jadwal_status';

    protected $description = 'Check and update JadwalKlinik status';

    public function handle()
    {
        // Get all JadwalKlinik records
        $jadwals = JadwalKlinik::all();

        foreach ($jadwals as $jadwal) {
            $tanggal = Carbon::parse($jadwal->tanggal);
            $jamMulai = Carbon::parse($jadwal->jam_mulai);
            $jamSelesai = Carbon::parse($jadwal->jam_selesai);

            // Check conditions and update status
            if ($tanggal->isPast() || $jamMulai->isPast()) {
                $jadwal->update(['status' => 'Nonaktif']);
            }
        }

        $this->info('JadwalKlinik status checked and updated successfully.');
    }
}