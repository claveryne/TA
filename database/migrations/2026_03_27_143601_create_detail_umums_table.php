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
        Schema::create('detail_umums', function (Blueprint $table) {
            $table->bigIncrements('id_detailU');
            $table->string('warnaU', 255);
            $table->integer('ukuranU');
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
        Schema::dropIfExists('detail_umums');
    }
};
