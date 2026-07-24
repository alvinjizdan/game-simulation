<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiKuis extends Model
{
    protected $table = 'nilai_kuis';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_user',
        'nama_modul',
        'skor_tertinggi'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
}
