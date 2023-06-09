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
                    'user_id' => 2,
                    'information' => "ユーザー2\nボーカルの初心者から経験者まで、個人レッスンでしっかりと学べるボーカルレッスンです\n初めての方でも、安心して受講いただけるように、レッスン内容や進め方について、講師がしっかりとサポートします。\nボーカルに必要な基礎的な技術から、発声・歌唱力の向上、音楽理論やアドリブなど、個人の希望や目的に合わせてカスタマイズされたレッスンを提供します。\nレッスンは、生徒様が歌いたい曲に合わせた指導も可能です。また、練習のための音源や楽譜もご提供しています。\nボーカルレッスンを通じて、生徒様の音楽のスキルアップや夢の実現を応援いたします。",
                    'image1' => null,
                    'image2' => null,
                    'image3' => null,
                    'is_visible' => 1,
                ],
                [
                    'user_id' => 3,
                    'information' => "ユーザー3\nボーカルの初心者から経験者まで、個人レッスンでしっかりと学べるボーカルレッスンです\n初めての方でも、安心して受講いただけるように、レッスン内容や進め方について、講師がしっかりとサポートします。\nボーカルに必要な基礎的な技術から、発声・歌唱力の向上、音楽理論やアドリブなど、個人の希望や目的に合わせてカスタマイズされたレッスンを提供します。\nレッスンは、生徒様が歌いたい曲に合わせた指導も可能です。また、練習のための音源や楽譜もご提供しています。\nボーカルレッスンを通じて、生徒様の音楽のスキルアップや夢の実現を応援いたします。",
                    'image1' => null,
                    'image2' => null,
                    'image3' => null,
                    'is_visible' => 1,
                ],
                [
                    'user_id' => 4,
                    'information' => "ユーザー4\nボーカルの初心者から経験者まで、個人レッスンでしっかりと学べるボーカルレッスンです\n初めての方でも、安心して受講いただけるように、レッスン内容や進め方について、講師がしっかりとサポートします。\nボーカルに必要な基礎的な技術から、発声・歌唱力の向上、音楽理論やアドリブなど、個人の希望や目的に合わせてカスタマイズされたレッスンを提供します。\nレッスンは、生徒様が歌いたい曲に合わせた指導も可能です。また、練習のための音源や楽譜もご提供しています。\nボーカルレッスンを通じて、生徒様の音楽のスキルアップや夢の実現を応援いたします。",
                    'image1' => null,
                    'image2' => null,
                    'image3' => null,
                    'is_visible' => 1,
                ],
            ],
        );
    }
}
