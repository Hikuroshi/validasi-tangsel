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
        Schema::table('perusahaans', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('tenaga_ahlis', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('perusahaan_id')->references('id')->on('perusahaans');
        });

        Schema::table('riwayat_pendidikans', function (Blueprint $table) {
            $table->foreign('tenaga_ahli_id')->references('id')->on('tenaga_ahlis');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('keahlians', function (Blueprint $table) {
            $table->foreign('tenaga_ahli_id')->references('id')->on('tenaga_ahlis');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('jenis_pekerjaans', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->foreign('jenis_pekerjaan_id')->references('id')->on('jenis_pekerjaans');
            $table->foreign('perusahaan_id')->references('id')->on('perusahaans');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('status_pekerjaans', function (Blueprint $table) {
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaans')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
        Schema::dropIfExists('tenaga_ahlis');
        Schema::dropIfExists('riwayat_pendidikans');
        Schema::dropIfExists('keahlians');
        Schema::dropIfExists('jenis_pekerjaans');
        Schema::dropIfExists('pekerjaans');
        Schema::dropIfExists('status_pekerjaans');
    }
};
