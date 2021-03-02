<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->word,
            'amount' => $this->faker->randomDigitNotNull,
        ];
    }

    public function lines()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'lines',
            ];
        });
    }

    public function time()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'time',
            ];
        });
    }
}
