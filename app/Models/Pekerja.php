<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
