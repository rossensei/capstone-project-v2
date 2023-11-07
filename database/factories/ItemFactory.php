<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'category_id' => fake()->randomElement(range(1,4)),
            'curr_stocks' => $data = fake()->randomNumber(4, false),
            'init_qty' => $data,
            'unit_id' => fake()->randomElement(range(1,3)),
        ];
    }
}
