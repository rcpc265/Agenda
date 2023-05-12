<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Visitor;
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
        $visitors = Visitor::pluck('id')->all();
        $users = User::pluck('id')->all();
        return [
            'subject' => $this->faker->word(),
            'name' => $this->faker->word(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'code' => $this->faker->randomNumber(8, true),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'canceled']),
            'office_name' => $this->faker->word(),
            'visitor_id' => $this->faker->randomElement($visitors),
            'user_id' => $this->faker->randomElement($users)
        ];
    }
}
