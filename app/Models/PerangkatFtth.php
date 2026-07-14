<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatFtth extends Model
{
    protected $table = 'perangkat_ftth';
    protected $primaryKey = 'id_perangkat';

    protected $fillable = [
        'nama_perangkat',
        'tipe_perangkat',
        'gambar_aset',
        'deskripsi_lengkap',
        'fungsi_utama',
        'urutan',
    ];
}
