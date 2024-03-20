<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected function sisaHari(): Attribute
    {
        return new Attribute(
            get: function () {
                $tgl_selesai = Carbon::parse($this->tgl_selesai);

                return now()->diffInDays($tgl_selesai);
            }
        );
    }

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

    protected function progressPekerjaan(): Attribute
    {
        return new Attribute(
            get: function () {
                $color = '';
                $percent = '';
                $desc = '';

                $status = $this->status_pekerjaan->status['slug'];
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

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }

    public function jenis_pekerjaan(): BelongsTo
    {
        return $this->belongsTo(JenisPekerjaan::class, 'jenis_pekerjaan_id');
    }

    public function status_pekerjaan(): BelongsTo
    {
        return $this->belongsTo(StatusPekerjaan::class, 'status_pekerjaan_id');
    }

    public function metode(): BelongsTo
    {
        return $this->belongsTo(Metode::class, 'metode_id');
    }

    public function tenaga_ahlis()
    {
        return $this->belongsToMany(TenagaAhli::class, 'pekerjaan_tenaga_ahli', 'pekerjaan_id', 'tenaga_ahli_id');
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
