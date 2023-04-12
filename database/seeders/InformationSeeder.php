<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('information')->insert(
            [
                [
                    'information' => "ボーカルレッス\n現役シンガーの技術があなたのものに！プロ志向の方からカラオケ上達まで！基礎レッスン25分、課題曲アドバイス25分の目的に応じた分かりやすいレッスンで1時間でのレベルアップも可能！",
                    'image' => null,
                ],
            ],
        );
    }
}
