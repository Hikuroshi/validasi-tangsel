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
            $table->string('telepon')->unique();
            $table->string('email')->unique();
            $table->text('alamat');
            $table->boolean('status_kontrak')->default('1');
            $table->unsignedBigInteger('perusahaan_id');
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
