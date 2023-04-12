<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Lesson::factory(100)->create();

        $this->call([
            UserSeeder::class,
            ReservationSeeder::class,
            InformationSeeder::class,
        ]);
    }
}
