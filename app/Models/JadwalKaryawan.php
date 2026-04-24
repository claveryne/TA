<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKaryawan extends Model
{
    protected $table = 'jadwal_karyawans';
    protected $primaryKey = 'id_jadwal';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'tanggal',
        'rutin',
        'tugas',
        'id_user'
    ];

    public function user() // Relasi ke user
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
