<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $guarded = ['user_id'];

    protected $fillable = [
        'namalengkap',
        'jeniskelamin',
        'tanggallahir',
        'alamat',
        'email',
        'nomortelepon',
        'password',
        'terakhir_login',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $latestRecord = static::latest()->first();
            $model->user_id = $latestRecord ? 'C-' . ((int)substr($latestRecord->user_id, 2) + 1) : 'C-1';
        });

        static::deleting(function ($user) {
            // Hapus gambar dari semua pets milik user
            $user->pets->each(function ($pet) {
                if ($pet->image) {
                    Storage::delete('public/'.$pet->image);
                }
            });
        });
    }

    public function pets()
    {
        return $this->hasMany(Pets::class, 'user_id', 'user_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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
