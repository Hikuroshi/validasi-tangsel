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
        Schema::table('badan_usahas', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('tenaga_ahlis', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usahas');
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
            $table->foreign('jenis_jasa_id')->references('id')->on('jenis_jasas');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('sub_pekerjaans', function (Blueprint $table) {
            $table->foreign('jenis_pekerjaan_id')->references('id')->on('jenis_pekerjaans');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->foreign('sub_pekerjaan_id')->references('id')->on('sub_pekerjaans');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans');
            $table->foreign('metode_id')->references('id')->on('metodes');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('kecamatans', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('metodes', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('jenis_jasas', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('pelaksanas', function (Blueprint $table) {
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usahas');
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaans');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('status_pelaksanas', function (Blueprint $table) {
            $table->foreign('pelaksana_id')->references('id')->on('pelaksanas')->cascadeOnDelete();
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badan_usahas');
        Schema::dropIfExists('tenaga_ahlis');
        Schema::dropIfExists('riwayat_pendidikans');
        Schema::dropIfExists('keahlians');
        Schema::dropIfExists('jenis_pekerjaans');
        Schema::dropIfExists('sub_pekerjaans');
        Schema::dropIfExists('pekerjaans');
        Schema::dropIfExists('kecamatans');
        Schema::dropIfExists('metodes');
        Schema::dropIfExists('jenis_jasas');
        Schema::dropIfExists('pelaksanas');
        Schema::dropIfExists('status_pelaksanas');
    }
};