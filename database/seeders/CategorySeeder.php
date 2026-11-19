<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['name' => 'Celulares', 'description' => 'Smartphones y teléfonos móviles nuevos'],
            ['name' => 'Laptops', 'description' => 'Equipos portátiles de oficina y gaming'],
            ['name' => 'Pantallas', 'description' => 'Repuestos de pantallas OLED y LCD'],
            ['name' => 'Baterías', 'description' => 'Repuestos de baterías internas para equipos'],
            ['name' => 'Cargadores', 'description' => 'Cubos de carga rápida y cargadores de laptop'],
            ['name' => 'Accesorios', 'description' => 'Audífonos, cables, fundas y protectores'],
        ];

        foreach ($categorias as $cat) {
            Category::create([
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'description' => $cat['description'],
                'is_active'   => true,
            ]);
        }
    }
}