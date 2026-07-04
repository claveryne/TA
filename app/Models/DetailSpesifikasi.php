<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSpesifikasi extends Model
{
    protected $table = 'detail_spesifikasi';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'merk',
        'warna',
        'ukuran',
        'kapasitas',
        'id_fasilitas'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
