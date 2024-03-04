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
        Schema::create('pelaksana_tenaga_ahli', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pelaksana_id');
            $table->foreign('pelaksana_id')->references('id')->on('pelaksanas');
            $table->unsignedBigInteger('tenaga_ahli_id');
            $table->foreign('tenaga_ahli_id')->references('id')->on('tenaga_ahlis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksana_tenaga_ahli');
    }
};
