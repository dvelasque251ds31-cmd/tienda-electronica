<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    public function definition(): array
    {
        $base = fake()->randomElement([
            'Samsung', 'Apple', 'Xiaomi', 'Lenovo', 'HP', 'Asus', 'Motorola', 'Anker',
        ]);
        $name = $base . ' ' . strtoupper(fake()->unique()->bothify('??-###'));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'country' => fake()->randomElement(['Corea del Sur', 'Estados Unidos', 'China', 'Taiwán']),
            'is_active' => true,
        ];
    }
}