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
        $dummyDate = $this->faker->dateTimeThisMonth; //開始時間と終了時間の調整

        return [
            'name' => $this->faker->name,
            'location' => $this->faker->name,
            'price' => $this->faker->randomElement([0, 10000]),
            'max_people' => $this->faker->numberBetween(1, 20),
            'start_date' => $dummyDate->format('Y-m-d H:i:s'),
            'end_date' => $dummyDate->modify('+1hour')->format('Y-m-d H:i:s'),
            'is_visible' => $this->faker->boolean
        ];
    }
}
