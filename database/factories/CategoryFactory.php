<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $base = fake()->randomElement([
            'Celulares', 'Laptops', 'Cargadores', 'Pantallas',
            'Baterías', 'Audífonos', 'Cables', 'Fundas',
        ]);
        $name = $base . ' ' . strtoupper(fake()->unique()->bothify('??-###'));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake('es_PE')->sentence(),
            'is_active' => true,
        ];
    }
}