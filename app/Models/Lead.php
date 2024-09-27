<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    // Definiendo la relación con Message
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
