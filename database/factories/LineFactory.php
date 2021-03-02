<?php

namespace Database\Factories;

use App\Models\Line;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Line::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'line_number' => $this->faker->numberBetween(1, 100),
            'book' => $this->faker->words($words = 2, $asText = true),
            'chapter' => $this->faker->sentence($words = 4)
        ];
    }
}
