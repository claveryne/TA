<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailLighting extends Model
{
    protected $table = 'detail_lightings';
    protected $primaryKey = 'id_detailL';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_fasilitas',
        'warnaL'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
