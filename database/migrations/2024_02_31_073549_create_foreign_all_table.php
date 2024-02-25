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

        Schema::table('kontraks', function (Blueprint $table) {
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usahas');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('jenis_pekerjaans', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('sub_pekerjaans', function (Blueprint $table) {
            $table->foreign('jenis_pekerjaan_id')->references('id')->on('jenis_pekerjaans');
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
        Schema::dropIfExists('kontraks');
        Schema::dropIfExists('jenis_pekerjaans');
        Schema::dropIfExists('sub_pekerjaans');
    }
};
