<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusPelaksana extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['active'];

    protected function active(): Attribute
    {
        return new Attribute(
            get: function () {
                $latestStatusKey = collect($this->only(['request', 'on_progress', 'reporting', 'done', 'pending', 'cancelled']))
                        ->filter(fn ($value, $key) => $value == true)
                        ->keys()
                        ->last();
                return ucwords(str_replace('_', ' ', $latestStatusKey));
            }
        );
    }

    public function pelaksana(): BelongsTo
    {
        return $this->belongsTo(Pelaksana::class, 'pelaksana_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
