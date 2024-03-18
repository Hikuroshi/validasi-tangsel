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
        Schema::create('pelaksanas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('badan_usaha_id');
            $table->unsignedBigInteger('pekerjaan_id');
            $table->string('no_kontrak');
            $table->date('tgl_kontrak');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('ppk');
            $table->string('pptk');
            $table->string('pho');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksanas');
    }
};
