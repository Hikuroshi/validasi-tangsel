<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusPekerjaan extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected function status(): Attribute
    {
        return new Attribute(
            get: function () {
                $statuses = [
                    [
                        'name' => 'Request',
                        'slug' => 'request',
                        'color' => 'primary',
                        'icon' => 'export',
                        'icon-lucide' => 'upload',
                    ],
                    [
                        'name' => 'On Progress',
                        'slug' => 'on_progress',
                        'color' => 'secondary',
                        'icon' => 'sync',
                        'icon-lucide' => 'refresh-ccw'
                    ],
                    [
                        'name' => 'Reporting',
                        'slug' => 'reporting',
                        'color' => 'info',
                        'icon' => 'book-alt',
                        'icon-lucide' => 'book',
                    ],
                    [
                        'name' => 'Done',
                        'slug' => 'done',
                        'color' => 'success',
                        'icon' => 'check',
                        'icon-lucide' => 'check',
                    ],
                    [
                        'name' => 'Pending',
                        'slug' => 'pending',
                        'color' => 'warning',
                        'icon' => 'pause-circle',
                        'icon-lucide' => 'pause',
                    ],
                    [
                        'name' => 'Cancelled',
                        'slug' => 'cancelled',
                        'color' => 'danger',
                        'icon' => 'times',
                        'icon-lucide' => 'x',
                    ]
                ];

                $matchedStatus = collect($statuses)->firstWhere('name', $this->nama);

                if ($matchedStatus) {
                    return $matchedStatus;
                }

                return [
                    'name' => 'Not Found',
                    'slug' => 'not_found',
                    'color' => 'dark',
                    'icon' => 'exclamation-circle'
                ];
            }
        );
    }

    public function pekerjaans(): HasMany
    {
        return $this->hasMany(Pekerjaan::class, 'status_pekerjaan_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
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
