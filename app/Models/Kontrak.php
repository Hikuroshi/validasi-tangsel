<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kontrak extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $appends = ['tgl_mulai_f', 'tgl_batas_f', 'status_kontrak'];

    protected function tglMulaiF(): Attribute
    {
        return new Attribute(
            get: function () {
                return Carbon::parse($this->tgl_mulai)->isoFormat('D MMMM YYYY');
            }
        );
    }

    protected function tglBatasF(): Attribute
    {
        return new Attribute(
            get: function () {
                $tglMulai = Carbon::parse($this->tgl_mulai);
                $tglBatas = $tglMulai->addDays($this->lama);

                return $tglBatas->isoFormat('D MMMM YYYY');
            }
        );
    }

    protected function statusKontrak(): Attribute
    {
        return new Attribute(
            get: function () {
                $tglMulai = Carbon::parse($this->tgl_mulai);
                $tglBatas = $tglMulai->addDays($this->lama);

                if ($tglMulai > now()) {
                    $status = 'Direncanakan';
                } elseif ($tglBatas >= now()) {
                    $status = 'Proses';
                } elseif ($this->tgl_selesai) {
                    $tglSelesai = Carbon::parse($this->tgl_selesai);
                    if ($tglSelesai <= $tglBatas) {
                        $status = 'Selesai';
                    } else {
                        $status = 'Selesai, Melewati batas waktu';
                    }
                } else {
                    $status = 'Tidak Selesai, Melewati batas waktu';
                }

                return $status;
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

    public function tenaga_ahlis(): BelongsToMany
    {
        return $this->belongsToMany(TenagaAhli::class, 'kontrak_tenaga_ahli', 'kontrak_id', 'tenaga_ahli_id');
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
