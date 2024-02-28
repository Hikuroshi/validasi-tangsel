<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenagaAhli extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    // protected $appends = ['status_f', 'kelamin_f'];

    protected function statusKontrakF(): Attribute
    {
        return new Attribute(
            get: fn () => $this->status_kontrak ? 'Tersedia' : 'Sedang Bekerja',
        );
    }

    protected function kelaminF(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->kelamin ? 'Laki-Laki' : 'Perempuan';
            }
        );
    }

    protected function statusF(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->status ? 'Aktif' : 'Tidak Aktif';
            }
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function badan_usaha(): BelongsTo
    {
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }

    public function riwayat_pendidikans(): HasMany
    {
        return $this->hasMany(RiwayatPendidikan::class, 'tenaga_ahli_id');
    }

    public function kontraks()
    {
        return $this->belongsToMany(Kontrak::class, 'kontrak_tenaga_ahli', 'tenaga_ahli_id', 'kontrak_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama',
                'includeTrashed' => true,
            ]
        ];
    }
}
