<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pekerjaan extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected function nilaiPaguF(): Attribute
    {
        return new Attribute(
            get: function () {
                return "Rp." . number_format($this->nilai_pagu, 0, '.', '.');
            }
        );
    }

    protected function nilaiKontrakF(): Attribute
    {
        return new Attribute(
            get: function () {
                return "Rp." . number_format($this->nilai_kontrak, 0, '.', '.');
            }
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function sub_pekerjaan(): BelongsTo
    {
        return $this->belongsTo(SubPekerjaan::class, 'sub_pekerjaan_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function metode(): BelongsTo
    {
        return $this->belongsTo(Metode::class, 'metode_id');
    }

    public function pelaksanas(): HasMany
    {
        return $this->hasMany(Pelaksana::class, 'pekerjaan_id');
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
