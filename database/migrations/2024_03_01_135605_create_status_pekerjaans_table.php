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
        Schema::create('status_pekerjaans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('keterangan')->nullable();
            $table->boolean('request')->default(false);
            $table->boolean('on_progress')->default(false);
            $table->boolean('reporting')->default(false);
            $table->boolean('done')->default(false);
            $table->boolean('pending')->default(false);
            $table->boolean('cancelled')->default(false);
            $table->unsignedBigInteger('pekerjaan_id');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pekerjaans');
    }
};
