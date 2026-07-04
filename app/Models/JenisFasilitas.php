<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisFasilitas extends Model
{
    use SoftDeletes;

    protected $table = 'jenis_fasilitas';
    protected $primaryKey = 'id_jenis';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_jenis'
    ];

    public function fasilitas() // Relasi ke fasilitas
    {
        return $this->hasMany(Fasilitas::class, 'id_jenis', 'id_jenis');
    }
}
