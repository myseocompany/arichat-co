<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserMessageSourceSeeder extends Seeder
{
    public function run()
    {
        // Definir las asignaciones de usuarios a message_sources
        $assignments = [
            ['user_id' => 1, 'message_source_id' => 1],
            ['user_id' => 2, 'message_source_id' => 2],
            ['user_id' => 3, 'message_source_id' => 3],
            ['user_id' => 3, 'message_source_id' => 4],
            
            
        ];

        // Insertar cada asignación en la tabla user_message_source
        foreach ($assignments as $assignment) {
            DB::table('user_message_sources')->insert([
                'user_id' => $assignment['user_id'],
                'message_source_id' => $assignment['message_source_id'],
                'is_active' => 1, // Activo por defecto
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
