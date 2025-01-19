<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageSource extends Model
{
    use HasFactory;
    public function getEndPoint(){
        return json_decode($this->settings)->webhook_url;
        
    }

    public function userMessageSources()
    {
        return $this->hasMany(UserMessageSource::class, 'message_source_id');
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
