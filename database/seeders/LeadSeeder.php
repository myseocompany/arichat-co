<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leads')->insert([
            'user_id' => 1, // Asegúrate de que este ID de usuario exista en tu base de datos
            'team_id' => 1, // Asegúrate de que este ID de equipo exista en tu base de datos
            'name' => 'Nicolás Navarro',
            'email' => 'nicolas@myseocompany.co', // Añade un correo electrónico si la columna es requerida
            'phone' => '573004410097',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        DB::table('leads')->insert([
            'user_id' => 1, // Asegúrate de que este ID de usuario exista en tu base de datos
            'team_id' => 1, // Asegúrate de que este ID de equipo exista en tu base de datos
            'name' => 'Luisa Cañas',
            'email' => 'admin@myseocompany.co', // Añade un correo electrónico si la columna es requerida
            'phone' => '573195094691',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        

        DB::table('leads')->insert([
            'user_id' => 1, // Asegúrate de que este ID de usuario exista en tu base de datos
            'team_id' => 1, // Asegúrate de que este ID de equipo exista en tu base de datos
            'name' => 'Kevin Virgen',
            'email' => 'soporterapido@myseocompany.co', // Añade un correo electrónico si la columna es requerida
            'phone' => '573244484504',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('leads')->insert([
            'user_id' => 1, // Asegúrate de que este ID de usuario exista en tu base de datos
            'team_id' => 1, // Asegúrate de que este ID de equipo exista en tu base de datos
            'name' => 'Maquiempanadas',
            'email' => 'mqe@myseocompany.co', // Añade un correo electrónico si la columna es requerida
            'phone' => '573044483357',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        
    }
}
