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
        Schema::create('pemeliharaans', function (Blueprint $table) {
            $table->bigIncrements('id_pemeliharaan');
            $table->string('jenis_pemeliharaan', 20);
            $table->string('nama_pemeliharaan', 255);
            $table->integer('jumlah_pemeliharaan')->nullable();
            $table->double('biaya_pemeliharaan')->nullable();
            $table->string('status_pemeliharaan', 20);
            $table->date('tglMulai_pemeliharaan');
            $table->date('tglSelesai_pemeliharaan')->nullable();
            $table->string('bukti_pemeliharaan', 255)->nullable();
            $table->string('keterangan_pemeliharaan', 255)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('id_ruangan')->nullable();
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangans')->onDelete('cascade');

            $table->unsignedBigInteger('id_fasilitas')->nullable();
            $table->foreign('id_fasilitas')->references('id_fasilitas')->on('fasilitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaans');
    }
};
