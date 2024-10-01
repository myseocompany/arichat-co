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
            [
                'lead_id' => 1,
                'user_id' => 1,
                'message_source_id' => 1,
                'message_type_id' => 1,
                'content' => 'Este es un mensaje de prueba.',
                'media_url' => null,
                'is_outgoing' => true,
                'sent_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}