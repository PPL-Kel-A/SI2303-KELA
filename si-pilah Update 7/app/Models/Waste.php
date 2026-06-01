<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    // nama tabel
    protected $table = 'wastes';

    // field yang boleh diisi
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'category',
        'weight',
        'tps',
        'image',
        'result',
        'status',
    ];

    // casting tipe data
    protected $casts = [
        'weight' => 'float',
        'result' => 'float',
    ];

    /**
     * Get the user that owns the waste submission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}