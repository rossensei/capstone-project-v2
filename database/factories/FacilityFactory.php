<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'facility_name' => fake()->word(),
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            'user_id' => fake()->randomElement(range(1,20))
        ];
    }
}
