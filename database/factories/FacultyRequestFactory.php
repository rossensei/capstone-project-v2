<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FacultyRequest>
 */
class FacultyRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => mt_rand(1, User::where('id', '!=', 21)->count()),
            'req_date' => Carbon::now()->toLocaleDateString(),
            'status' => fake()->randomElement(['Pending', 'Accepted', 'Accepted', 'Accepted', 'Rejected']),
            'signature' => 'image/path/signature.png',
        ];
    }
}
