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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->bigIncrements('id_fasilitas');
            $table->string('nama_fasilitas', 255);
            $table->string('jenis_fasilitas', 20);
            $table->integer('jumlah_fasilitas')->nullable();
            $table->string('merk_fasilitas', 255);
            $table->string('foto_fasilitas', 255)->nullable();
            $table->string('keterangan_fasilitas', 255)->nullable();
            $table->string('status_fasilitas', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
