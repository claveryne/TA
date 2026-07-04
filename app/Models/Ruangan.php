<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruangan extends Model
{
    use SoftDeletes;

    protected $table = 'ruangans';
    protected $primaryKey = 'id_ruangan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_ruangan',
        'jenis_ruangan',
        'ukuran_ruangan',
        'kapasitas_ruangan',
        'foto_ruangan',
        'keterangan_ruangan',
        'status_ruangan'
    ];

    public function pemeliharaan() // Relasi ke pemeliharaan
    {
        return $this->hasMany(Pemeliharaan::class, 'id_ruangan', 'id_ruangan');
    }

    public function pemesanan() // Relasi ke pemesanan
    {
        return $this->hasMany(Pemesanan::class, 'id_ruangan', 'id_ruangan');
    }
}
