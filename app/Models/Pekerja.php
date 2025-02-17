<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomResetPasswordNotification;
use App\Models\JadwalKlinik;

class Pekerja extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'pekerja';

    protected $table = 'pekerja';

    public $incrementing = false;
    protected $primaryKey = 'pekerja_id';

    protected $fillable = [
        'pekerja_id',
        'namapekerja',
        'peran',
        'jeniskelamin',
        'tanggallahir',
        'alamat',
        'email',
        'nomortelepon',
        'foto',
        'password',
        'terakhir_login',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pekerja) {
            $latestId = static::max('pekerja_id');
            $nextIdNumber = Str::startsWith($latestId, 'P-') ? (int) Str::after($latestId, 'P-') + 1 : 1;
            $nextId = 'P-' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
            $pekerja->pekerja_id = $nextId;
        });
    }

    public function jadwalKlinik()
    {
        return $this->hasMany(JadwalKlinik::class, 'pekerja_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
