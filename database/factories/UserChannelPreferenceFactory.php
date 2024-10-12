<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\MessageSource;
use App\Models\UserChannelPreference;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserChannelPreferenceFactory extends Factory
{
    protected $model = UserChannelPreference::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Relacionamos con un usuario creado por el factory
            'channel_id' => MessageSource::factory(), // Relacionamos con un canal creado por el factory
            'is_active' => $this->faker->boolean(80), // 80% de probabilidad de que esté activo
        ];
    }
}
