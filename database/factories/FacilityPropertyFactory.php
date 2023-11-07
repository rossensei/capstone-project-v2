<?php

namespace Database\Factories;

use App\Models\Facility;
use App\Models\Property;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FacilityProperty>
 */
class FacilityPropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => mt_rand(1, Property::count()),
            'facility_id' => mt_rand(1, Facility::count()),
            'tag_no' =>  fake()->randomNumber(5, true),
            'date_acquired' =>  Carbon::now()->format('Y-m-d'),
            'condition' =>  'Good',
        ];
    }
}
