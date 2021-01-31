<?php

namespace Database\Factories;

use App\Models\Scorecard;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScorecardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Scorecard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'score' => $this->faker->numberBetween(1,100),
            'course_id' => $this->faker->numberBetween(1,10),
            'golfer_id' => $this->faker->numberBetween(1, 100),
            'category_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
