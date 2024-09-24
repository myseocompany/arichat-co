<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    protected $fillable = [
        'lead_id',
        'user_id',
        'channel_id',
        'message_type_id',
        'content',
        'is_outgoing'
    ];

    
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
