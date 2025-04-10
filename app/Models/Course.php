<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'cost', 'duration', 'modality', 'academy_id'];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
}