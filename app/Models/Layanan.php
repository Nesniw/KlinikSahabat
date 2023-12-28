<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\JadwalKlinik;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'layanan_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'layanan_id',
        'kategori_layanan',
        'nama_layanan',
        'jenis_layanan_hewan',
        'stok_kandang', 
        'biaya_booking',
        'harga_layanan',
        'deskripsi_layanan'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layanan) {
            $latestId = static::max('layanan_id');
            $nextIdNumber = Str::startsWith($latestId, 'L-') ? (int) Str::after($latestId, 'L-') + 1 : 1;
            $nextId = 'L-' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
            $layanan->layanan_id = $nextId;
        });
    }


    public function jadwalKlinik()
    {
        return $this->hasMany(JadwalKlinik::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'layanan_id');
    }

    
}
