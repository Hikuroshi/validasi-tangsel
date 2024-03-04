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
        Schema::create('badan_usahas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('slug')->unique()->nullable();
            $table->string('npwp')->unique();
            $table->string('sertifikat');
            $table->string('registrasi');
            $table->string('direktur');
            $table->text('alamat');
            $table->string('email')->unique();
            $table->string('telepon')->unique();
            $table->string('no_akta');
            $table->date('tgl_akta');
            $table->text('klasifikasi');
            $table->boolean('status');
            $table->integer('jumlah_pekerjaan')->default('0');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badan_usahas');
    }
};
