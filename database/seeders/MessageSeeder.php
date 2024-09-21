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
        // Asumiendo que los campos incluyen user_id, lead_id, content, is_outgoing, created_at y updated_at
        $messages = [
            [
                'user_id' => 1,  // Suponiendo que es el mismo usuario que 'escucha'
                'lead_id' => 1,  // ID del lead que dice "Hola"
                'channel_id' => 1,
                'message_type_id' => 1,
                'content' => 'Hola',  // Mensaje de entrada del lead
                'is_outgoing' => false,  // Este mensaje es de entrada
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,  // ID del usuario que recibe el mensaje
                'lead_id' => 1,  // ID del lead que envía el mensaje
                'channel_id' => 1,
                'message_type_id' => 1,
                'content' => '¡Hola! Bienvenido a nuestro servicio.',
                'is_outgoing' => true,  // Este mensaje es de entrada
                'created_at' => Carbon::now()->subMinutes(5),
                'updated_at' => Carbon::now()->subMinutes(5),
                
            ],
            [
                'user_id' => 1,
                'lead_id' => 1,
                'channel_id' => 1,
                'message_type_id' => 1,
                'content' => '¿Hay algo en lo que pueda asistirte hoy?',
                'is_outgoing' => true,  // Este mensaje es de salida
                'created_at' => Carbon::now()->subMinutes(10),
                'updated_at' => Carbon::now()->subMinutes(10),
            ],
            
        ];

        DB::table('messages')->insert($messages);
    }
}
