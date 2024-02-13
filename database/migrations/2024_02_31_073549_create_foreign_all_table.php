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

        Schema::table('kontraks', function (Blueprint $table) {
            $table->foreign('perusahaan_id')->references('id')->on('perusahaans');
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
        Schema::dropIfExists('kontraks');
    }
};
