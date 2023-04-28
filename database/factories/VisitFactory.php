<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject' => $this->faker->word(),
            'name' => $this->faker->word(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'code' => $this->faker->randomNumber(8, true),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'canceled']),
            'office_name' => $this->faker->word()
        ];
    }
}
