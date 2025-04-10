<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'birth_date', 'father_id'];

    public function father()
    {
        return $this->belongsTo(Father::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}