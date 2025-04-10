<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'sent_date', 'communicable_id', 'communicable_type'];

    public function communicable()
    {
        return $this->morphTo();
    }
}