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
                'team_id' => 2,  // Asegúrate de que este team_id exista en tu base de datos
                'is_default' => true,
                'settings' => json_encode([
                    'webhook_url' => 'https://api.watoolbox.com/webhooks/MKXPHWB1L',
                    'phone_number' => '573142132987',
                    
                ]),
                'APIKEY' => '+G_H%<Gr425`MnWuw(N0Rp$d}+£GT/0w@|JL/}BIn0n_IH7iDr',
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
                    'webhook_url' => 'https://api.watoolbox.com/webhooks/5383ZPOSC',
                    'phone_number' => '573044483357',
                    
                ]),
                'APIKEY' => '7CH5>pya;\.5!)@j-g_b.J|@[$%|r~0S7{-)`@IUR,?9_011;Q',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        
        DB::table('message_sources')->insert([
            [
                'type' => 'WhatsApp ',
                'team_id' => 3,  // Asegúrate de que este team_id exista en tu base de datos
                'is_default' => true,
                'settings' => json_encode([
                    'webhook_url' => 'https://api.watoolbox.com/webhooks/UOKEGPO4Q',
                    'phone_number' => '573206945548',
                    
                ]),
                'APIKEY' => 'II([:{~Lm}+FXA}$Hmc+90`ZBVca[Wo42}a.(bg1sX!Oo5)X',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        
    }
}
