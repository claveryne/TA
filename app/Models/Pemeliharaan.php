<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
{
    protected $table = 'pemeliharaans';
    protected $primaryKey = 'id_pemeliharaan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'jenis_pemeliharaan',
        'nama_pemeliharaan',
        'jumlah_pemeliharaan',
        'biaya_pemeliharaan',
        'status_pemeliharaan',
        'tglMulai_pemeliharaan',
        'tglSelesai_pemeliharaan',
        'bukti_pemeliharaan',
        'keterangan_pemeliharaan'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function ruangan() // Relasi ke ruangan
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}
