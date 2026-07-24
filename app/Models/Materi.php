<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    protected $primaryKey = 'id_materi';

    protected $fillable = [
        'nama_modul',
        'judul',
        'deskripsi',
        'url_video',
        'urutan'
    ];
}
