<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;

    const PENDING = 'pendiente';
    const SENT = 'enviado';
    const FAILED = 'fallido';
    
    protected $fillable = ['title', 'message', 'sent_date', 'criteria_course_id', 'criteria_min_age', 'criteria_max_age'];
    protected $casts = [
        'sent_date' => 'datetime',
    ];
    protected $with = ['recipients'];

    public function recipients()
    {
        return $this->hasMany(CommunicationRecipient::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'criteria_course_id');
    }
}