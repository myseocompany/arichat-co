<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('users')->insert([
            'name' => 'Soporte Rápido',
            'email' => 'soporterapido@myseocompany.co',
            'current_team_id' => 1,
            'password' => Hash::make('myseo2025'), // Asegúrate de cambiar 'your_default_password' por una contraseña real segura
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

/*
        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'soporterapido@myseocompany.co',
            'password' => bcrypt('myseo2025'),
        ]);
        */
    }
}
