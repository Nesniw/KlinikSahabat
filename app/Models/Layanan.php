<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\KategoriLayanan;
use App\Models\JadwalKlinik;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'layanan_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['layanan_id', 'kategori_layanan_id', 'nama_layanan', 'biaya_booking', 'harga_layanan', 'deskripsi_layanan'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layanan) {
            $latestId = static::max('layanan_id');
            $nextId = Str::startsWith($latestId, 'L-') ? (int) Str::after($latestId, 'L-') + 1 : 1;
            $layanan->layanan_id = 'L-' . $nextId;
        });
    }

    // Relasi dengan model KategoriLayanan
    public function kategoriLayanan()
    {
        return $this->belongsTo(KategoriLayanan::class, 'kategori_layanan_id', 'kategori_layanan_id');
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
