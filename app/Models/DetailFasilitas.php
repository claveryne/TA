<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailFasilitas extends Model
{
    protected $table = 'detail_fasilitas';
    protected $primaryKey = 'id_detailF';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'jumlah_fasilitas',
        'id_fasilitas',
        'id_pemesanan'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function pemesanan() // Relasi ke pemesanan
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}
