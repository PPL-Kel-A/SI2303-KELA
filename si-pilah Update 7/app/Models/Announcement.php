<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'konten',
        'kategori', // <-- Menambahkan field kategori sesuai permintaan
        'start_at',
        'end_at',
        'read_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function getStatusAttribute(): string
    {
        $now = now();

        if ($this->start_at && $this->start_at > $now) {
            return 'Akan Tayang';
        }

        if ($this->end_at && $this->end_at < $now) {
            return 'Selesai';
        }

        return 'Sedang Tayang';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}