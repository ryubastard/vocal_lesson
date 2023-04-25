<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $availableHour = $this->faker->numberBetween(10, 18); //10時～18時
        $minutes = [0, 30]; // 00分か 30分
        $mKey = array_rand($minutes); //ランダムにキーを取得
        $addHour = $this->faker->numberBetween(1, 3); // イベント時間 1時間～3時間 

        $dummyDate = $this->faker->dateTimeThisMonth; // 今月分をランダムに取得
        $startDate = $dummyDate->setTime($availableHour, $minutes[$mKey]);
        $clone = clone $startDate; // そのままmodifyするとstartDateも変わるためコピー
        $endDate = $clone->modify('+' . $addHour . 'hour');

        return [
            'name' => $this->faker->name,
            'location' => $this->faker->name,
            'price' => $this->faker->randomElement([0, 10000]),
            'max_people' => $this->faker->numberBetween(1, 20),
            'start_date' => $dummyDate->format('Y-m-d H:i:s'),
            'end_date' => $dummyDate->modify('+1hour')->format('Y-m-d H:i:s'),
            'is_visible' => $this->faker->boolean,
            'teacher_id' => $this->faker->numberBetween(2, 4) // 2~4のランダムな値をセット
        ];
    }
}
