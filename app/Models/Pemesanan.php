<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';
    protected $primaryKey = 'id_pemesanan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'no_nota',
        'nama_pemesan',
        'telp_pemesan',
        'email_pemesan',
        'alamat_pemesan',
        'nama_acara',
        'jumlah_orang',
        'tgl_pesan',
        'tgl_mulai',
        'tgl_selesai',
        'status_pemesanan',
        'bukti_pemesanan',
        'keterangan_pemesanan',
        'id_ruangan',
        'id_user'
    ];

    public function user() // Relasi ke user
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function ruangan() // Relasi ke ruangan
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function detailF() // Relasi ke detail fasilitas
    {
        return $this->hasMany(DetailFasilitas::class, 'id_pemesanan', 'id_pemesanan');
    }
}
