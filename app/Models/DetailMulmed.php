<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailMulmed extends Model
{
    protected $table = 'detail_mulmeds';
    protected $primaryKey = 'id_detailMM';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_fasilitas',
        'warnaMM'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
