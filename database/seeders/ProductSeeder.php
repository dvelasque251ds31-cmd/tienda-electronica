<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catIds = Category::pluck('id');
        $brandIds = Brand::pluck('id');

        // Catálogo base con los 3 tipos del RF03
        $fijos = [
            [
                'category_id' => Category::where('name', 'Celulares')->first()->id,
                'brand_id'    => Brand::where('name', 'Apple')->first()->id,
                'tipo'        => 'equipo_nuevo',
                'sku'         => 'CEL-APL-001',
                'name'        => 'iPhone 13 128GB',
                'model'       => 'A2633',
                'description' => 'Equipo nuevo sellado en caja, garantía 12 meses.',
                'purchase_price' => 2350.00,
                'sale_price'  => 2890.00,
                'stock'       => 12,
            ],
            [
                'category_id' => Category::where('name', 'Pantallas')->first()->id,
                'brand_id'    => Brand::where('name', 'Samsung')->first()->id,
                'tipo'        => 'repuesto',
                'sku'         => 'REP-SAM-002',
                'name'        => 'Pantalla AMOLED Galaxy A54',
                'model'       => 'SM-A546E',
                'description' => 'Repuesto original con marco para servicio técnico.',
                'purchase_price' => 240.00,
                'sale_price'  => 350.00,
                'stock'       => 18,
            ],
            [
                'category_id' => Category::where('name', 'Cargadores')->first()->id,
                'brand_id'    => Brand::where('name', 'Anker')->first()->id,
                'tipo'        => 'accesorio',
                'sku'         => 'ACC-ANK-003',
                'name'        => 'Cargador Rápido USB-C 35W',
                'model'       => 'A2667',
                'description' => 'Cargador compacto PowerIQ 3.0 compatible con iPhone y Android.',
                'purchase_price' => 55.00,
                'sale_price'  => 89.00,
                'stock'       => 30,
            ],
        ];

        foreach ($fijos as $prod) {
            Product::create($prod);
        }

        // 25 productos adicionales distribuidos en las categorías y marcas existentes
        foreach (range(1, 25) as $i) {
            Product::factory()->create([
                'category_id' => $catIds->random(),
                'brand_id'    => $brandIds->random(),
            ]);
        }

        // 2 productos sin stock para probar RN01
        Product::factory()->count(2)->sinStock()->create([
            'category_id' => $catIds->random(),
            'brand_id'    => $brandIds->random(),
        ]);
    }
}