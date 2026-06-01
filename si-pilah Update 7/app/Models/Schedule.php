<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'waktu_jemput',
        'kategori',
        'nama_petugas',
        'kelurahan',
    ];

    protected $casts = [
        'waktu_jemput' => 'datetime',
    ];
}
