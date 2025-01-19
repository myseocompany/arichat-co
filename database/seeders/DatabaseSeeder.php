<?php

namespace Database\Seeders;

//use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();


 
        $this->call([
            UserSeeder::class, // Seeder de usuarios
            TeamSeeder::class, // Seeder de equipos, si tienes uno
            MessageSourceSeeder::class, // Seeder de Message Sources
            LeadSeeder::class, // Seeder de la tabla intermedia User_Message_Source
            MessageTypeSeeder::class, // Seeder de la tabla User_Teams
            MessageSeeder::class,
            UserMessageSourceSeeder::class,
            TeamUserSeeder::class

        ]);
        
        

    }
}
