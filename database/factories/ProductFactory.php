<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $tipo = fake()->randomElement(['equipo_nuevo', 'repuesto', 'accesorio']);
        $purchase = fake()->randomFloat(2, 30, 2500);
        $sale = round($purchase * 1.30, 2);

        return [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'tipo' => $tipo,
            'sku' => 'SKU-' . fake()->unique()->numerify('######'),
            'name' => fake()->randomElement([
                'iPhone 13 128GB', 'Samsung Galaxy A54', 'Xiaomi Redmi Note 13',
                'Laptop Lenovo IdeaPad 3', 'Pantalla OLED iPhone 13', 'Batería Original Samsung S22',
                'Cargador Rápido USB-C 35W', 'Audífonos Inalámbricos ANC',
            ]) . ' ' . fake()->numerify('##'),
            'model' => 'MOD-' . strtoupper(fake()->bothify('??-###')),
            'description' => fake('es_PE')->sentence(10),
            'purchase_price' => $purchase,
            'sale_price' => $sale,
            'stock' => fake()->numberBetween(8, 40),
            'min_stock' => 5,
            'warranty_months' => $tipo === 'equipo_nuevo' ? 12 : 3,
            'is_active' => true,
        ];
    }

    public function sinStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }
}