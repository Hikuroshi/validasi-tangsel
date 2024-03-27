<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perusahaan extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected function statusF(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->status ? 'Aktif' : 'Tidak Aktif';
            }
        );
    }

    protected function pekerjaanThisYear(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->pekerjaans()->whereYear('created_at', now()->year);
            }
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tenaga_ahlis(): HasMany
    {
        return $this->hasMany(TenagaAhli::class, 'perusahaan_id');
    }

    public function pekerjaans(): HasMany
    {
        return $this->hasMany(Pekerjaan::class, 'perusahaan_id');
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
