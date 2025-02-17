<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';
    public $incrementing = false;

    protected $fillable = [
        'transaksi_id', 
        'jadwal_klinik_id',
        'user_id', 
        'layanan_id', 
        'pekerja_id', 
        'kode_pasien', 
        'tanggal',
        'waktu',  
        'harga', 
        'total_biaya', 
        'lama_tinggal', 
        'bukti_transfer',
        'status', 
        'catatan',
        'waktu_ekspirasi',
        'alasan_reject',
    ];

    public static function boot()
    {
        parent::boot();

        // Event saat akan menyimpan record baru
        static::creating(function ($transaksi) {

            // Ambil tanggal sekarang
            $currentDate = Carbon::now();

            // Ambil tanggal terakhir dari database
            $lastDate = DB::table('transaksi')->orderByDesc('created_at')->value('created_at');

            // Convert $lastDate to a Carbon instance
            $lastDate = new Carbon($lastDate);

            // Cek apakah tanggal hari ini berbeda dengan tanggal terakhir yang disimpan
            if (!$lastDate || !$currentDate->isSameDay($lastDate)) {
                // Reset nilai auto-increment ke 1 karena tanggal berbeda
                $lastIncrement = 0;
            } else {
                // Jika tanggal sama, ambil nilai auto-increment terakhir
                $lastIncrement = DB::table('transaksi')
                    ->whereDate('created_at', $lastDate)
                    ->orderByDesc('transaksi_id')
                    ->value('transaksi_id');

                // Jika tidak ada data, set nilai auto-increment ke 0
                $lastIncrement = $lastIncrement ? (int)substr($lastIncrement, -3) : 0;
            }

            // Increment nilai auto-increment
            $lastIncrement++;

            // Format transaction_id sesuai kebutuhan
            $transaksi->transaksi_id = $currentDate->format('Ymd') . str_pad($lastIncrement, 3, '0', STR_PAD_LEFT);
        });
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function jadwalKlinik()
    {
        return $this->belongsTo(JadwalKlinik::class, 'jadwal_klinik_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','user_id');
    }

    public function pets()
    {
        return $this->belongsTo(Pets::class, 'kode_pasien', 'kode_pasien');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'transaksi_id');
    }
}
