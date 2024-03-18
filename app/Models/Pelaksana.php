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

    protected function progressPelaksana(): Attribute
    {
        return new Attribute(
            get: function () {
                $color = '';
                $percent = '';
                $desc = '';

                $status = $this->status_pelaksana_f['slug'];
                $start_date = $this->tgl_kontrak;
                $end_date = $this->tgl_selesai;

                if ($status === 'done') {
                    $color = 'success';
                    $percent = '100';
                    $desc = 'Pekerjaan telah selesai dengan baik. Terima kasih atas dedikasi dan kerja keras Anda dalam menyelesaikan tugas ini.';
                } else {
                    $today = now();
                    $start = Carbon::parse($start_date);
                    $end = Carbon::parse($end_date);

                    if ($today > $end) {
                        $color = 'secondary';
                        $percent = '100';
                        $desc = 'Waktu pengerjaan telah habis, namun jangan menyerah! Teruskan usaha dan semangat Anda untuk menyelesaikan tugas ini.';
                    } else {
                        $days_passed = $start->diff($today)->days;
                        $total_days = $start->diff($end)->days;
                        $percent = $days_passed > 0 ? round(($days_passed / $total_days) * 100) : 0;

                        if ($percent <= 25) {
                            $color = 'primary';
                            $desc = 'Sedang dalam tahap awal pengerjaan. Tetap semangat dan konsisten dalam menyelesaikan tugas ini.';
                        } elseif ($percent <= 50) {
                            $color = 'info';
                            $desc = 'Progres pengerjaan sudah mencapai setengahnya. Lanjutkan usaha Anda untuk menyelesaikan tugas dengan baik.';
                        } elseif ($percent <= 75) {
                            $color = 'warning';
                            $desc = 'Hampir selesai! Tetap fokus dan pastikan tugas ini diselesaikan dengan baik.';
                        } else {
                            $color = 'danger';
                            $desc = 'Waktu yang tersisa untuk menyelesaikan tugas semakin sedikit. Percepat progres pengerjaan agar tugas dapat diselesaikan tepat waktu.';
                        }
                    }
                }

                return [
                    'color' => $color,
                    'percent' => $percent,
                    'desc' => $desc,
                ];
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
