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
                'team_id' => 1,  // Asegúrate de que este team_id exista en tu base de datos
                'user_id' => 1,
                'is_default' => true,
                'settings' => json_encode([
                    'webhook_url' => 'https://api.watoolbox.com/webhooks/19YC5Q41W',
                    'phone_number' => '573004410097'
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('message_sources')->insert([
            [
                'type' => 'WhatsApp ',
                'team_id' => 1,  // Asegúrate de que este team_id exista en tu base de datos
                'user_id' => 2,
                'is_default' => false,
                'settings' => json_encode([
                    'webhook_url' => 'https://api.watoolbox.com/webhooks/NKHQ97FJ7',
                    'phone_number' => '573044483357'
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
