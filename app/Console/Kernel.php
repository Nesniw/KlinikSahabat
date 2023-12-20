<?php

namespace App\Console;

use App\Console\Commands\CleanFailedUploads;
use App\Console\Commands\UpdateJadwalStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Pekerja;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Ini schedule buat jalanin command membersihkan file gambar yang gagal di upload tiap hari
        $schedule->command(CleanFailedUploads::class)->dailyAt('0:00');

        $schedule->command('update:jadwal_status')->dailyAt('17:00');

        // Ini schedule buat jalanin command untuk menghapus otomatis akun pekerja yang sudah dinonaktifkan dalam 30 hari
        $schedule->call(function () {
            Pekerja::where('status', 'Nonaktif')
                ->where('nonaktif_at', '<=', now()->subDays(30))
                ->delete();
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        $this->load([
            Commands\UpdateJadwalStatus::class,
        ]);

        require base_path('routes/console.php');
    }
}
