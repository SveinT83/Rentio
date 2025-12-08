<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1, // Will be overridden in tests
            'ad_name' => fake()->sentence(3),
            'price' => fake()->numberBetween(100, 10000),
            'price_period' => fake()->randomElement(['day', 'week', 'month', 'year']),
            'description' => fake()->paragraph(),
            'category_id' => 1, // Will be overridden in tests
            'subcategory_id' => null,
            'location' => fake()->city(),
            'municipality' => fake()->city().' Kommune',
            'images' => [],
            'is_active' => true,
            'is_available' => true,
        ];
    }
}
