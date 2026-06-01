<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'waste_id',
        'rating',
        'comment',
        'is_visible',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function waste()
    {
        return $this->belongsTo(Waste::class);
    }
}
