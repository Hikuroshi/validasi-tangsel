<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BadanUsaha extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tenaga_ahlis(): HasMany
    {
        return $this->hasMany(TenagaAhli::class, 'badan_usaha_id');
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
