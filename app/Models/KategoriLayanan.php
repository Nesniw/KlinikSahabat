<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriLayanan extends Model
{
    use HasFactory;

    protected $table = 'kategori_layanan';
    protected $primaryKey = 'kategori_layanan_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['nama_kategori', 'deskripsi_kategori'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            $latestId = static::max('kategori_layanan_id');
            $nextId = Str::startsWith($latestId, 'K-') ? (int) Str::after($latestId, 'K-') + 1 : 1;
            $kategori->kategori_layanan_id = 'K-' . $nextId;
        });
    }


}
