<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageSourceSeeder extends Seeder
{
    public function run()
    {
        DB::table('message_sources')->insert([
            [
                'type' => 'WhatsApp',
                'team_id' => 3,  // Asegúrate de que este team_id exista en tu base de datos
                'is_default' => true,
                'settings' => json_encode([
                    'webhook_url' => 'https://api.watoolbox.com/webhooks/19YC5Q41W',
                    'phone_number' => '573004410097',
                    
                ]),
                'APIKEY' => 'pHPC9TbqDGWVAPRGpzX0VxxNGPJeuXj03uWqt0QQ9b1e9bdf',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('message_sources')->insert([
            [
                'type' => 'WhatsApp ',
                'team_id' => 3,  // Asegúrate de que este team_id exista en tu base de datos
                'is_default' => false,
                'settings' => json_encode([
                    'webhook_url' => 'https://api.watoolbox.com/webhooks/NKHQ97FJ7',
                    'phone_number' => '573044483357',
                    
                ]),
                'APIKEY' => 'pHPC9TbqDGWVAPRGpzX0VxxNGPJeuXj03uWjasf32qf1e9bdf',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
