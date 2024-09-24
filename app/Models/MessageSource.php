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
}
