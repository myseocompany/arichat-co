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
        $team = Team::where('name', 'Maquiempanadas')->first();

        if ($team) {
            // Define los usuarios que deseas asociar al equipo
            $users = User::whereIn('email', [
                'nicolas@myseocompany.co',
                'soporterapido@myseocompany.co',
            ])->get();

            foreach ($users as $user) {
                // Asocia cada usuario al equipo
                DB::table('team_user')->insert([
                    'team_id' => $team->id,
                    'user_id' => $user->id,
                    'role' => 'agent',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // Establece el equipo actual para los usuarios
                $user->switchTeam($team);
            }
        }
    }
}
