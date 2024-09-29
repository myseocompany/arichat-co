<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'user_id', 'team_id'];

    // Definiendo la relación con Message
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    // Función para obtener las iniciales del nombre
    public function getInitials($maxLetters = 2)
    {
        // Divide el nombre en palabras
        $words = explode(' ', $this->name);
        
        // Toma las primeras letras de las palabras (hasta $maxLetters palabras)
        $initials = '';
        for ($i = 0; $i < min(count($words), $maxLetters); $i++) {
            $initials .= strtoupper(substr($words[$i], 0, 1));
        }

        return $initials;
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

}
