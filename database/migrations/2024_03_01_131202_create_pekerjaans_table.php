<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pekerjaans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('bidang_id');
            $table->unsignedBigInteger('perusahaan_id');
            $table->string('no_kontrak');
            $table->date('tgl_kontrak');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('ppk');
            $table->string('pptk');
            $table->text('deskripsi');
            $table->string('nilai_pagu');
            $table->string('nilai_kontrak');
            $table->text('lokasi');
            $table->string('sumber_dana');
            $table->year('thn_anggaran');
            $table->string('jenis_kontruksi');
            $table->unsignedBigInteger('jenis_pekerjaan_id');
            $table->unsignedBigInteger('metode_id');
            $table->unsignedBigInteger('status_pekerjaan_id');
            $table->boolean('pekerjaan_selesai')->default('0');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjaans');
    }
};
