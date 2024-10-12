<?php

namespace Database\Factories;

use App\Models\MessageSource;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageSourceFactory extends Factory
{
    protected $model = MessageSource::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company, // Nombre del canal (puede ser cualquier string)
            'description' => $this->faker->sentence, // Descripción breve del canal
            'type' => $this->faker->randomElement(['WhatsApp', 'Telegram', 'Email']), // Tipo de canal
        ];
    }
}
