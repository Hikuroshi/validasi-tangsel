<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function perusahaans(): HasMany
    {
        return $this->hasMany(Perusahaan::class, 'author_id');
    }

    public function jenis_pekerjaans(): HasMany
    {
        return $this->hasMany(JenisPekerjaan::class, 'author_id');
    }

    public function keahlians(): HasMany
    {
        return $this->hasMany(Keahlian::class, 'author_id');
    }

    public function riwayat_pendidikans(): HasMany
    {
        return $this->hasMany(RiwayatPendidikan::class, 'author_id');
    }

    public function sub_pekerjaans(): HasMany
    {
        return $this->hasMany(SubPekerjaan::class, 'author_id');
    }

    public function tenaga_ahlis(): HasMany
    {
        return $this->hasMany(TenagaAhli::class, 'author_id');
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

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
        'password' => 'hashed',
    ];
}
