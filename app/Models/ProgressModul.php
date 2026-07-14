<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressModul extends Model
{
    protected $table = 'progress_modul';
    protected $primaryKey = 'id_progress';

    protected $fillable = [
        'id_user',
        'nama_modul',
        'tingkat_kesulitan',
        'status_tugas'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
}
