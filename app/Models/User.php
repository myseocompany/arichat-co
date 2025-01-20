<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use App\Models\MessageSource;
use App\Models\UserMessageSource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function userMessageSources()
    {
        return $this->hasMany(UserMessageSource::class);
    }

    

    public function activeMessageSource()
    {
        return $this->hasOneThrough(
            MessageSource::class,
            UserMessageSource::class,
            'user_id', // Foreign key en UserMessageSource
            'id',      // Foreign key en MessageSource
            'id',      // Local key en User
            'message_source_id' // Local key en UserMessageSource
        )->where('is_active', 1);
    }

    public function messageSources()
    {
        return $this->hasManyThrough(
            MessageSource::class,
            UserMessageSource::class,
            'user_id',
            'id',
            'id',
            'message_source_id'
        );
    }

    public function getDefaultMessageSource()
{
    $user = $this;

    // Obtener los IDs de los equipos del usuario
    $teamIds = $user->allTeams()->pluck('id');

    if ($teamIds->isEmpty()) {
        Log::warning('El usuario no tiene equipos asignados: ' . $user->id);
        return null;
    }

    

    // Buscar canal predeterminado en la tabla user_message_source
    $defaultUserMessageSource = $user->userMessageSources()
        ->where('is_active', 1)
        ->where('is_default', 1)
        ->first();
        
    if ($defaultUserMessageSource) {
        return $defaultUserMessageSource->messageSource; // Retornar el canal predeterminado del usuario
    }

    // Si no hay canal predeterminado en user_message_source, buscar en message_sources del equipo
    $defaultTeamMessageSource = MessageSource::whereIn('team_id', $teamIds)
        ->where('is_default', 1)
        ->first();

    if ($defaultTeamMessageSource) {
        return $defaultTeamMessageSource; // Retornar el canal predeterminado del equipo
    }

    Log::warning('No se encontró un MessageSource predeterminado para el usuario o sus equipos: ' . $user->id);
    return null;
}



    

}
