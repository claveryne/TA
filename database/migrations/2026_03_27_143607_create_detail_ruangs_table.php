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
        Schema::create('detail_ruangs', function (Blueprint $table) {
            $table->bigIncrements('id_detailR');
            $table->integer('ukuranR');
            $table->integer('kapasitasR');
            $table->timestamps();

            $table->unsignedBigInteger('id_fasilitas');
            $table->foreign('id_fasilitas')->references('id_fasilitas')->on('fasilitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ruangs');
    }
};
