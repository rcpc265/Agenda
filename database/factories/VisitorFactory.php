<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'entity' => $this->faker->company,
            'dni' => $this->faker->unique()->randomNumber(8, true),
            'phone_number' => $this->faker->optional()->phoneNumber,
            'email' => $this->faker->unique()->email(),
        ];
    }
}
