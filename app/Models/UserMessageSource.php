<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessageSource extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'message_source_id', 'is_active'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    // Relación con MessageSource
    public function messageSource()
    {
        return $this->belongsTo(MessageSource::class, 'message_source_id');
    }
        */

    public function messageSource()
{
    return $this->belongsTo(MessageSource::class);
}


    

    
}
