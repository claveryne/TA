<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use SoftDeletes;

    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_fasilitas',
        'jumlah_fasilitas',
        'foto_fasilitas',
        'keterangan_fasilitas',
        'status_fasilitas',
        'id_jenis'
    ];

    public function jenisFasilitas() // Relasi ke jenis fasilitas
    {
        return $this->belongsTo(JenisFasilitas::class, 'id_jenis', 'id_jenis');
    }

    public function detailSpesifikasi() // Relasi ke detail spesifikasi
    {
        return $this->hasOne(DetailSpesifikasi::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function detailF() // Relasi ke detail fasilitas (pemesanan)
    {
        return $this->hasMany(DetailFasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function pemeliharaan() // Relasi ke pemeliharaan
    {
        return $this->hasMany(Pemeliharaan::class, 'id_fasilitas', 'id_fasilitas');
    }
}
