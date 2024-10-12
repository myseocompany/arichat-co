<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            // Mensaje asociado a un lead del equipo (user_id 1, message_source para el team)
            [
                'lead_id' => 1,
                'user_id' => 1,
                'message_source_id' => 1, // message_source del equipo (team_id 1)
                'message_type_id' => 1,
                'content' => 'Este es un mensaje de prueba del equipo.',
                'media_url' => null,
                'is_outgoing' => true,
                'sent_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Mensaje asociado al mismo lead, pero con message_source asignado al usuario
            [
                'lead_id' => 1,
                'user_id' => 1,
                'message_source_id' => 2, // message_source asignado específicamente al usuario 1
                'message_type_id' => 1,
                'content' => 'Este es un mensaje personal del usuario 1.',
                'media_url' => null,
                'is_outgoing' => false,
                'sent_at' => Carbon::now()->subMinutes(5),
                'created_at' => Carbon::now()->subMinutes(5),
                'updated_at' => Carbon::now()->subMinutes(5),
            ],
            // Mensaje de otro lead relacionado al equipo (para ver más variedad)
            [
                'lead_id' => 2,
                'user_id' => 1,
                'message_source_id' => 1, // También del team_id 1
                'message_type_id' => 1,
                'content' => 'Mensaje de otro lead del equipo.',
                'media_url' => null,
                'is_outgoing' => true,
                'sent_at' => Carbon::now()->subMinutes(10),
                'created_at' => Carbon::now()->subMinutes(10),
                'updated_at' => Carbon::now()->subMinutes(10),
            ],
            // Mensaje personal de otro usuario en el mismo equipo
            [
                'lead_id' => 2,
                'user_id' => 2,
                'message_source_id' => 2, // message_source asignado específicamente al usuario 2
                'message_type_id' => 1,
                'content' => 'Mensaje personal del usuario 2.',
                'media_url' => null,
                'is_outgoing' => false,
                'sent_at' => Carbon::now()->subMinutes(15),
                'created_at' => Carbon::now()->subMinutes(15),
                'updated_at' => Carbon::now()->subMinutes(15),
            ]
        ]);
    }
}
