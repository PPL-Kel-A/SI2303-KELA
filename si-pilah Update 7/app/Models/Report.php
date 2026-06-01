<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'detail_alamat',
        'foto_laporan',
        'status',
        'is_rewarded'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasOne(ReportFeedback::class);
    }
}