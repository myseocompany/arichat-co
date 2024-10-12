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
        'message_source_id',
        'message_type_id',
        'content',
        'is_outgoing'
    ];

    
    // Relación con Lead
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    // Si necesitas acceder al equipo, lo harías a través del Lead
    public function team()
    {
        return $this->lead->team();
    }

    // Relación con MessageSource
    public function messageSource()
    {
        return $this->belongsTo(MessageSource::class, 'message_source_id');
    }
}
