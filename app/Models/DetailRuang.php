<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRuang extends Model
{
    protected $table = 'detail_ruangs';
    protected $primaryKey = 'id_detailR';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_fasilitas',
        'ukuranR',
        'kapasitasR'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
