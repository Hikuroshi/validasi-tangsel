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
        Schema::create('kontraks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('perusahaan_id');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->integer('lama');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontraks');
    }
};
