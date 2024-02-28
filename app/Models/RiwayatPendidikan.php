<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPendidikan extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected function thnMasukF(): Attribute
    {
        return new Attribute(
            get: function () {
                return Carbon::parse($this->tgl_masuk)->isoFormat('D MMMM YYYY');
            }
        );
    }

    protected function thnLulusF(): Attribute
    {
        return new Attribute(
            get: function () {
                return Carbon::parse($this->tgl_lulus)->isoFormat('D MMMM YYYY');
            }
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tenaga_ahli(): BelongsTo
    {
        return $this->belongsTo(TenagaAhli::class, 'tenaga_ahli_id');
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
