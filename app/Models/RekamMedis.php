<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'rekam_medis_id';
    public $incrementing = false;

    protected $fillable = [
        'rekam_medis_id',
        'transaksi_id',
        'kode_pasien',
        'keterangan_medis',
        'medikasi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rekamMedis) {
            $latestId = static::max('rekam_medis_id');
            $nextIdNumber = Str::startsWith($latestId, 'RM-') ? (int) Str::after($latestId, 'RM-') + 1 : 1;
            $nextId = 'RM-' . str_pad($nextIdNumber, 5, '0', STR_PAD_LEFT);
            $rekamMedis->rekam_medis_id = $nextId;
        });
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function pets()
    {
        return $this->belongsTo(Pets::class, 'kode_pasien', 'kode_pasien');
    }
}
