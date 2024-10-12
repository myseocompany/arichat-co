<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MessageSource;
use App\Models\UserChannelPreference;
use Illuminate\Database\Seeder;

class UserChannelPreferencesSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();  // Obtiene todos los usuarios
        $channels = MessageSource::all();  // Obtiene todos los canales

        foreach ($users as $user) {
            foreach ($channels as $channel) {
                UserChannelPreference::factory()->create([
                    'user_id' => $user->id,
                    'channel_id' => $channel->id,
                    'is_active' => true,  // Activo por defecto
                ]);
            }
        }
    }
}
