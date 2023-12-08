<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Pets;

class CleanFailedUploads extends Command
{
    protected $signature = 'clean:failed-uploads';
    protected $description = 'Clean up failed uploads';

    public function handle()
    {
        // Tentukan direktori tempat file-file gagal disimpan
        $directory = 'pets_images';

        // Dapatkan daftar file dalam kedua lokasi
        $files = array_merge(
            Storage::disk('public')->files($directory),
            Storage::disk('public')->files('storage/app/public/' . $directory)
        );

        // Dapatkan daftar nama file yang terkait dengan entri database
        $filesInDatabase = Pets::pluck('image')->toArray();

        // Filter file yang tidak terkait dengan database
        $unrelatedFiles = array_diff($files, $filesInDatabase);

        // Hapus file-file yang tidak terkait di kedua lokasi
        foreach ($unrelatedFiles as $file) {
            Storage::disk('public')->delete($file);
        }

        // Tampilkan pesan sukses
        $this->info('Failed uploads cleaned up successfully.');
    }
}