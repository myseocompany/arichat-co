<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            ['name' => 'My SEO Company'],
            ['name' => 'Elemental'],
            ['name' => 'Maquiempanadas'],
            ['name' => 'Xtensor'],
            ['name' => 'GOI'],
            ['name' => 'Beautydent'],
            ['name' => 'Vitar'],
            ['name' => 'CDAV'],
            ['name' => 'XPower'],
        ];

        foreach ($teams as $team) {
            DB::table('teams')->insert([
                'name' => $team['name'],
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
