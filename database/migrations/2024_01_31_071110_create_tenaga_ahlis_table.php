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
        Schema::create('tenaga_ahlis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('slug')->unique()->nullable();
            $table->string('nik')->unique();
            $table->string('npwp')->unique();
            $table->unsignedBigInteger('perusahaan_id')->nullable();
            $table->string('jabatan');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->text('alamat');
            $table->boolean('kelamin');
            $table->string('email')->unique()->nullable();
            $table->string('telepon')->unique()->nullable();
            $table->text('keahlian');
            $table->boolean('status');
            $table->boolean('status_pekerjaan')->default('1');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenaga_ahlis');
    }
};
