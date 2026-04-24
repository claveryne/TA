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
        Schema::create('jadwal_karyawans', function (Blueprint $table) {
            $table->bigIncrements('id_jadwal');
            $table->date('tanggal')->nullable();
            $table->string('rutin', 10)->nullable();
            $table->string('tugas', 255);
            $table->timestamps();

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_karyawans');
    }
};
