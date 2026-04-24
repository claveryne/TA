<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSound extends Model
{
    protected $table = 'detail_sounds';
    protected $primaryKey = 'id_detailS';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_fasilitas',
        'warnaS'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
