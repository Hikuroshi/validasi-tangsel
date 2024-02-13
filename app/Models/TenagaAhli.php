<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenagaAhli extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected function statusKontrakF(): Attribute
    {
        return new Attribute(
            get: fn () => $this->status_kontrak ? 'Tersedia' : 'Sedang Bekerja',
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
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
