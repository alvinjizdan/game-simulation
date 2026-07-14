<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function progressModul()
    {
        return $this->hasMany(ProgressModul::class, 'id_user', 'id_user');
    }
}
