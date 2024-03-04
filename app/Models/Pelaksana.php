<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelaksana extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected function tglKontrakF(): Attribute
    {
        return new Attribute(
            get: function () {
                return Carbon::parse($this->tgl_kontrak)->isoFormat('D MMMM YYYY');
            }
        );
    }

    protected function tglMulaiF(): Attribute
    {
        return new Attribute(
            get: function () {
                return Carbon::parse($this->tgl_mulai)->isoFormat('D MMMM YYYY');
            }
        );
    }

    protected function tglSelesaiF(): Attribute
    {
        return new Attribute(
            get: function () {
                return Carbon::parse($this->tgl_selesai)->isoFormat('D MMMM YYYY');
            }
        );
    }

    protected function statusPelaksanaF(): Attribute
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

                $latestStatus = $this->status_pelaksanas()->latest()->first();

                if ($latestStatus) {
                    $latestStatusKey = collect($latestStatus->toArray())
                        ->only(['request', 'on_progress', 'reporting', 'done', 'pending', 'cancelled'])
                        ->filter(fn ($value, $key) => $value == true)
                        ->keys()
                        ->last();

                    if ($latestStatusKey != null) {
                        $status = collect($statuses)->where('slug', $latestStatusKey)->first();
                        $status['keterangan'] = $latestStatus->keterangan;

                        return $status;
                    }
                }

                return [
                    'name' => 'Not Found',
                    'slug' => 'not_found',
                    'keterangan' => 'unavailable',
                    'color' => 'dark',
                    'icon' => 'exclamation-circle'
                ];
            }
        );
    }

    // protected function tglBatasF(): Attribute
    // {
    //     return new Attribute(
    //         get: function () {
    //             $tglMulai = Carbon::parse($this->tgl_mulai);
    //             $tglBatas = $tglMulai->addDays($this->lama);

    //             return $tglBatas->isoFormat('D MMMM YYYY');
    //         }
    //     );
    // }

    // protected function tglSelesaiF(): Attribute
    // {
    //     return new Attribute(
    //         get: function () {
    //             if ($this->tgl_selesai) {
    //                 return Carbon::parse($this->tgl_selesai)->isoFormat('D MMMM YYYY');
    //             } else {
    //                 return 'Belum selesai';
    //             }
    //         }
    //     );
    // }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function badan_usaha(): BelongsTo
    {
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }

    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function status_pelaksanas(): HasMany
    {
        return $this->hasMany(StatusPelaksana::class, 'pelaksana_id');
    }

    public function tenaga_ahlis()
    {
        return $this->belongsToMany(TenagaAhli::class, 'pelaksana_tenaga_ahli', 'pelaksana_id', 'tenaga_ahli_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['badan_usaha.nama', 'pekerjaan.nama'],
                'includeTrashed' => true,
            ]
        ];
    }
}
