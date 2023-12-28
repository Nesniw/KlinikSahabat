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
    ];

    public static function boot()
    {
        parent::boot();

        // Event saat akan menyimpan record baru
        static::creating(function ($transaksi) {

            // Ambil tanggal dari tabel jadwal_klinik
            $lastDate = DB::table('jadwal_klinik')->orderByDesc('tanggal')->value('tanggal');

            // Convert $lastDate to a Carbon instance
            $lastDate = new Carbon($lastDate);

            // Ambil nilai auto-increment
            $lastIncrement = DB::table('transaksi')->max(DB::raw('CAST(SUBSTRING(transaksi_id, 9) AS SIGNED)'));

            // Jika tidak ada data, set nilai auto-increment ke 0
            $lastIncrement = $lastIncrement ?? 0;

            // Format transaction_id sesuai kebutuhan
            $transaksi->transaksi_id = $lastDate->format('Ymd') . str_pad($lastIncrement + 1, 3, '0', STR_PAD_LEFT);
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
