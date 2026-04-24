<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_fasilitas',
        'jenis_fasilitas',
        'jumlah_fasilitas',
        'merk_fasilitas',
        'foto_fasilitas',
        'keterangan_fasilitas',
        'status_fasilitas'
    ];

    public function detailF() // Relasi ke detail fasilitas
    {
        return $this->hasMany(DetailFasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function detailL() // Relasi ke detail lighting
    {
        return $this->hasOne(DetailLighting::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function detailMM() // Relasi ke detail multimedia
    {
        return $this->hasOne(DetailMulmed::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function detailM() // Relasi ke detail musik
    {
        return $this->hasOne(DetailMusik::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function detailR() // Relasi ke detail ruang
    {
        return $this->hasOne(DetailRuang::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function detailS() // Relasi ke detail sound
    {
        return $this->hasOne(DetailSound::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function detailU() // Relasi ke detail umum
    {
        return $this->hasOne(DetailUmum::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function pemeliharaan() // Relasi ke pemeliharaan
    {
        return $this->hasMany(Pemeliharaan::class, 'id_fasilitas', 'id_fasilitas');
    }
}
