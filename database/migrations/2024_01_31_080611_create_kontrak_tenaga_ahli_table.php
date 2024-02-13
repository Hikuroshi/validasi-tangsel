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
        Schema::create('kontrak_tenaga_ahli', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kontrak_id');
            $table->foreign('kontrak_id')->references('id')->on('kontraks');
            $table->unsignedBigInteger('tenaga_ahli_id');
            $table->foreign('tenaga_ahli_id')->references('id')->on('tenaga_ahlis');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_tenaga_ahli');
    }
};
