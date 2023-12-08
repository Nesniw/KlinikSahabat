<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pasien',
        'user_id',
        'namapasien',
        'jenishewan',
        'ras',
        'jeniskelamin',
        'umur_tahun',
        'umur_bulan',
        'berat',
        'tipedarah',
        'alergi',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public $incrementing = false; // to disable auto-incrementing (kalo gak ada ini tipe varcharnya gak muncul)
    protected $guarded = [];
    protected $primaryKey = 'kode_pasien';
}
