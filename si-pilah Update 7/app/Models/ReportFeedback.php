<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportFeedback extends Model
{
    protected $table = 'report_feedbacks';
    
    protected $fillable = [
        'report_id',
        'admin_id',
        'description',
        'photo',
    ];

    /**
     * Get the report that this feedback belongs to
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Get the admin user who created this feedback
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
