<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $fillable = ['method', 'amount', 'payment_date', 'enrollment_id'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}