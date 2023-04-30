<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservations')->insert([
            [
                'user_id' => 2,
                'lesson_id' => 3,
                'email' => 'admin@admin.com',
                'number_of_people' => 5,
            ], [
                'user_id' => 2,
                'lesson_id' => 1,
                'email' => 'manager@manager.com',
                'number_of_people' => 3,
            ], [
                'user_id' => 5,
                'lesson_id' => 4,
                'email' => 'admin@admin.com',
                'number_of_people' => 2,
            ], [
                'user_id' => 3,
                'lesson_id' => 5,
                'email' => 'manager@manager.com',
                'number_of_people' => 2,
            ]
        ]);
    }
}
