<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JadwalKlinik extends Model
{
    use HasFactory;

    protected $table = 'jadwal_klinik';
    protected $primaryKey = 'jadwal_klinik_id';
    public $incrementing = false;
    protected $fillable = ['jadwal_klinik_id','layanan_id', 'pekerja_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jadwalKlinik) {
            $latestId = static::max('jadwal_klinik_id');

            if ($latestId) {
                // Extract the numeric part of the ID and increment it
                $nextId = (int) substr($latestId, 2) + 1;
            } else {
                // If no existing records, start with 1
                $nextId = 1;
            }

            // Pad the numeric part with leading zeros
            $paddedNextId = str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $jadwalKlinik->jadwal_klinik_id = 'J-' . $paddedNextId;
        });
    }

    public function getNamaHariAttribute()
    {
        // Mengambil nama hari berdasarkan tanggal
       
        $namaHari = Carbon::parse($this->tanggal)->locale('id')->dayName;

        return $namaHari;
    }
    
    // Accessor untuk mendapatkan jam mulai dalam format 'H:i'
    public function getJamMulaiAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    // Accessor untuk mendapatkan jam selesai dalam format 'H:i'
    public function getJamSelesaiAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id', 'layanan_id');
    }

    public function pekerja()
    {
        return $this->belongsTo(Pekerja::class, 'pekerja_id', 'pekerja_id');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'jadwal_klinik_id');
    }
}
