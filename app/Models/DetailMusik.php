<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailMusik extends Model
{
    protected $table = 'detail_musiks';
    protected $primaryKey = 'id_detailM';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_fasilitas',
        'warnaM'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
