<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SaleDetail>
 */
class SaleDetailFactory extends Factory
{
    public function definition(): array
    {
        $qty = fake()->numberBetween(1, 3);
        $price = fake()->randomFloat(2, 40, 1500);

        return [
            'sale_id' => Sale::factory(),
            'product_id' => Product::factory(),
            'quantity' => $qty,
            'unit_price' => $price,
            'subtotal' => round($qty * $price, 2),
        ];
    }
}