<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Team;

class TeamUserSeeder extends Seeder
{
    public function run()
    {
        // Obtener la fecha y hora actuales
        $now = Carbon::now();

        // Insertar los datos en la tabla `team_user`
        DB::table('team_user')->insert([
            [
                'team_id' => 1,
                'user_id' => 1,
                'role' => 'owner', // Rol asignado
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'team_id' => 2,
                'user_id' => 2,
                'role' => 'owner', // Rol asignado
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'team_id' => 3,
                'user_id' => 3,
                'role' => 'owner', // Rol asignado
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Mensaje de confirmación en consola
        $this->command->info('Tabla `team_user` sembrada con éxito.');
    }
}
