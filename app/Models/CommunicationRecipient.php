<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationRecipient extends Model
{
    use HasFactory;

    protected $table = 'communication_recipient';
    protected $fillable = [
        'delivery_status',
        'communication_id',
        'user_id',
        'recipient_id',
        'recipient_type',
        'status',
        'is_resent',
        'resent_at',
        'read_at',
    ];
    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function communication()
    {
        return $this->belongsTo(Communication::class);
    }

    public function recipient()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
