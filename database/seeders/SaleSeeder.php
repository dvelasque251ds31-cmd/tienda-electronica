<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $vendedores = User::pluck('id');

        foreach (range(1, 15) as $n) {
            $productosDisponibles = Product::where('stock', '>=', 3)->inRandomOrder()->take(2)->get();
            if ($productosDisponibles->isEmpty()) {
                continue;
            }

            $subtotal = 0;
            $lineas = [];

            foreach ($productosDisponibles as $prod) {
                $qty = rand(1, 2);
                $lineSubtotal = round($prod->sale_price * $qty, 2);
                $subtotal += $lineSubtotal;

                $lineas[] = [
                    'product'    => $prod,
                    'quantity'   => $qty,
                    'unit_price' => $prod->sale_price, // RN03: congela el precio de venta
                    'subtotal'   => $lineSubtotal,
                ];
            }

            $tax = round($subtotal * 0.18, 2);
            $sale = Sale::create([
                'user_id'           => $vendedores->random(),
                'invoice_number'    => 'BOL-' . str_pad((string) $n, 6, '0', STR_PAD_LEFT),
                'customer_name'     => fake('es_PE')->name(),
                'customer_document' => fake()->numerify('########'),
                'subtotal'          => $subtotal,
                'tax'               => $tax,
                'total'             => round($subtotal + $tax, 2),
                'payment_method'    => fake()->randomElement(['efectivo', 'tarjeta', 'yape_plin', 'transferencia']),
                'status'            => 'completada',
            ]);

            foreach ($lineas as $linea) {
                $sale->details()->create([
                    'product_id' => $linea['product']->id,
                    'quantity'   => $linea['quantity'],
                    'unit_price' => $linea['unit_price'],
                    'subtotal'   => $linea['subtotal'],
                ]);

                // RN02: descuenta stock automáticamente
                $linea['product']->decrement('stock', $linea['quantity']);
            }
        }
    }
}