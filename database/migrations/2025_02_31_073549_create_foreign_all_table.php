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
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('tenaga_ahlis', function (Blueprint $table) {
            $table->foreign('perusahaan_id')->references('id')->on('perusahaans')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('riwayat_pendidikans', function (Blueprint $table) {
            $table->foreign('tenaga_ahli_id')->references('id')->on('tenaga_ahlis')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('keahlians', function (Blueprint $table) {
            $table->foreign('tenaga_ahli_id')->references('id')->on('tenaga_ahlis')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('jenis_pekerjaans', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('metodes', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->foreign('bidang_id')->references('id')->on('bidangs')->cascadeOnDelete();
            $table->foreign('perusahaan_id')->references('id')->on('perusahaans')->cascadeOnDelete();
            $table->foreign('jenis_pekerjaan_id')->references('id')->on('jenis_pekerjaans')->cascadeOnDelete();
            $table->foreign('status_pekerjaan_id')->references('id')->on('status_pekerjaans')->cascadeOnDelete();
            $table->foreign('metode_id')->references('id')->on('metodes')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('status_pekerjaans', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('dinasans', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('bidangs', function (Blueprint $table) {
            $table->foreign('dinasan_id')->references('id')->on('dinasans')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('dinasan_id')->references('id')->on('dinasans')->cascadeOnDelete();
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
        Schema::dropIfExists('pekerjaans');
        Schema::dropIfExists('jenis_pekerjaans');
        Schema::dropIfExists('metodes');
        Schema::dropIfExists('status_pekerjaans');
        Schema::dropIfExists('dinasans');
    }
};
