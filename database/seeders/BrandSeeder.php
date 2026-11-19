<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            ['name' => 'Apple', 'country' => 'Estados Unidos'],
            ['name' => 'Samsung', 'country' => 'Corea del Sur'],
            ['name' => 'Xiaomi', 'country' => 'China'],
            ['name' => 'Lenovo', 'country' => 'China'],
            ['name' => 'HP', 'country' => 'Estados Unidos'],
            ['name' => 'Anker', 'country' => 'China'],
        ];

        foreach ($marcas as $marca) {
            Brand::create([
                'name'      => $marca['name'],
                'slug'      => Str::slug($marca['name']),
                'country'   => $marca['country'],
                'is_active' => true,
            ]);
        }
    }
}