<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keahlian extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected function thnSertifikatF(): Attribute
    {
        return new Attribute(
            get: function () {
                return Carbon::parse($this->thn_sertifikat)->isoFormat('D MMMM YYYY');
            }
        );
    }

    protected function fileSertifikatF(): Attribute
    {
        return new Attribute(
            get: function () {
                $fileContents = file_get_contents(storage_path('app/' . $this->file_sertifikat));
                return base64_encode($fileContents);
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
