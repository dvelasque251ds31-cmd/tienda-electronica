<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 50, 3000);
        $tax = round($subtotal * 0.18, 2);

        return [
            'user_id' => User::factory(),
            'invoice_number' => 'BOL-' . fake()->unique()->numerify('######'),
            'customer_name' => fake('es_PE')->name(),
            'customer_document' => fake()->numerify('########'),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => round($subtotal + $tax, 2),
            'payment_method' => fake()->randomElement(['efectivo', 'tarjeta', 'yape_plin', 'transferencia']),
            'status' => 'completada',
            'notes' => null,
        ];
    }
}