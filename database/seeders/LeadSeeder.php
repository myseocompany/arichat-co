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
            'user_id' => 3, // Asegúrate de que este ID de usuario exista en tu base de datos
            'team_id' => 3, // Asegúrate de que este ID de equipo exista en tu base de datos
            'name' => 'Nicolás Navarro',
            'email' => 'nicolas@myseocompany.co', // Añade un correo electrónico si la columna es requerida
            'phone' => '573004410097',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        DB::table('leads')->insert([
            'user_id' => 2, // Asegúrate de que este ID de usuario exista en tu base de datos
            'team_id' => 2, // Asegúrate de que este ID de equipo exista en tu base de datos
            'name' => 'Michael',
            'email' => 'admin@myseocompany.co', // Añade un correo electrónico si la columna es requerida
            'phone' => '573205534914',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('leads')->insert([
            'user_id' => 1, // Asegúrate de que este ID de usuario exista en tu base de datos
            'team_id' => 1, // Asegúrate de que este ID de equipo exista en tu base de datos
            'name' => 'Juan David',
            'email' => 'soporterapido@myseocompany.co', // Añade un correo electrónico si la columna es requerida
            'phone' => '573125407247',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $leads = [];
        $now = Carbon::now();
                // Crear 40 leads asignados a usuarios y equipos válidos
                for ($i = 1; $i <= 120; $i++) {
                    $leads[] = [
                        'user_id' => $i % 3 + 1, // Asignar a usuarios con IDs 1, 2, o 3
                        'team_id' => $i % 3 + 1, // Asignar a equipos con IDs 1, 2, o 3
                        'name' => "Lead $i", // Nombre dinámico del lead
                        'email' => "lead$i@company.com", // Email dinámico del lead
                        'phone' => '57300' . rand(1000000, 9999999), // Generar un teléfono aleatorio
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
        
                // Insertar los leads en la base de datos
                //DB::table('leads')->insert($leads);

    }
}
