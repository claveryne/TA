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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->bigIncrements('id_pemesanan');
            $table->string('no_nota')->unique();
            $table->string('nama_pemesan', 255);
            $table->string('telp_pemesan', 15);
            $table->string('email_pemesan', 255);
            $table->string('alamat_pemesan', 255);
            $table->string('nama_acara', 255);
            $table->integer('jumlah_orang');
            $table->dateTime('tgl_pesan');
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->string('status_pemesanan', 20);
            $table->string('bukti_pemesanan', 255)->nullable();
            $table->string('keterangan_pemesanan', 255)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('id_ruangan');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangans')->onDelete('cascade');

            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
