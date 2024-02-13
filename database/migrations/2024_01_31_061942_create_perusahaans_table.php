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
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('slug')->unique()->nullable();
            $table->string('npwp')->unique();
            $table->string('telepon')->unique();
            $table->string('email')->unique();
            $table->text('alamat');
            $table->integer('jumlah_kontrak')->default('0');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};
