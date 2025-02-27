<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Office>
 */
class OfficeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'district_id' => 1,
            'is_district' => fake()->boolean(),
            'name' => fake()->domainName(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'image' => fake()->imageUrl(),
        ];
    }
}
