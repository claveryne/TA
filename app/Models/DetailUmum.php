<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailUmum extends Model
{
    protected $table = 'detail_umums';
    protected $primaryKey = 'id_detailU';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_fasilitas',
        'warnaU',
        'ukuranU'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
