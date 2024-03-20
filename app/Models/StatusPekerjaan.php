<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusPekerjaan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['active'];

    protected function active(): Attribute
    {
        return new Attribute(
            get: function () {
                $statuses = [
                    [
                        'name' => 'Request',
                        'slug' => 'request',
                        'color' => 'primary',
                        'icon' => 'export',
                    ],
                    [
                        'name' => 'On Progress',
                        'slug' => 'on_progress',
                        'color' => 'secondary',
                        'icon' => 'sync'
                    ],
                    [
                        'name' => 'Reporting',
                        'slug' => 'reporting',
                        'color' => 'info',
                        'icon' => 'book-alt'
                    ],
                    [
                        'name' => 'Done',
                        'slug' => 'done',
                        'color' => 'success',
                        'icon' => 'check'
                    ],
                    [
                        'name' => 'Pending',
                        'slug' => 'pending',
                        'color' => 'warning',
                        'icon' => 'pause-circle'
                    ],
                    [
                        'name' => 'Cancelled',
                        'slug' => 'cancelled',
                        'color' => 'danger',
                        'icon' => 'times'
                    ]
                ];

                $latestStatusKey = collect($this->only(['request', 'on_progress', 'reporting', 'done', 'pending', 'cancelled']))
                        ->filter(fn ($value, $key) => $value == true)
                        ->keys()
                        ->last();

                return collect($statuses)->firstWhere('slug', $latestStatusKey);
            }
        );
    }

    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
