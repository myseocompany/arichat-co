<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChannelPreference extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'channel_id', 'is_active'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los canales
    public function channel()
    {
        return $this->belongsTo(MessageSource::class, 'channel_id');
    }
}

