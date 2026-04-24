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
        Schema::create('detail_fasilitas', function (Blueprint $table) {
            $table->bigIncrements('id_detailF');
            $table->integer('jumlah_fasilitas');
            $table->timestamps();

            $table->unsignedBigInteger('id_fasilitas')->nullable();
            $table->foreign('id_fasilitas')->references('id_fasilitas')->on('fasilitas')->onDelete('cascade');

            $table->unsignedBigInteger('id_pemesanan');
            $table->foreign('id_pemesanan')->references('id_pemesanan')->on('pemesanans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_fasilitas');
    }
};
