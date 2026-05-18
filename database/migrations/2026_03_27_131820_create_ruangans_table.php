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
        Schema::create('ruangans', function (Blueprint $table) {
            $table->bigIncrements('id_ruangan');
            $table->string('nama_ruangan', 20);
            $table->string('jenis_ruangan', 20);
            $table->double('ukuran_ruangan');
            $table->integer('kapasitas_ruangan');
            $table->string('foto_ruangan', 255)->nullable();
            $table->string('keterangan_ruangan', 255)->nullable();
            $table->string('status_ruangan', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};
