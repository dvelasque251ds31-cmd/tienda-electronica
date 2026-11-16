<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario Administrador de prueba
        User::updateOrCreate(
            ['email' => 'admin@tienda.com'],
            [
                'name' => 'Administrador Tienda',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Categorías
        $categories = [
            ['name' => 'Laptops y Computadoras', 'slug' => 'laptops-computadoras', 'description' => 'Equipos portátiles y de escritorio'],
            ['name' => 'Smartphones', 'slug' => 'smartphones', 'description' => 'Teléfonos inteligentes y móviles'],
            ['name' => 'Repuestos y Componentes', 'slug' => 'repuestos-componentes', 'description' => 'Pantallas, baterías, memorias RAM y SSD'],
            ['name' => 'Accesorios y Periféricos', 'slug' => 'accesorios-perifericos', 'description' => 'Cargadores, cables, fundas, mouse y teclados'],
            ['name' => 'Audio y Sonido', 'slug' => 'audio-sonido', 'description' => 'Audífonos, parlantes y micrófonos'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Marcas
        $brands = [
            ['name' => 'Samsung', 'slug' => 'samsung', 'country' => 'Corea del Sur'],
            ['name' => 'Apple', 'slug' => 'apple', 'country' => 'Estados Unidos'],
            ['name' => 'Lenovo', 'slug' => 'lenovo', 'country' => 'China'],
            ['name' => 'HP', 'slug' => 'hp', 'country' => 'Estados Unidos'],
            ['name' => 'Xiaomi', 'slug' => 'xiaomi', 'country' => 'China'],
            ['name' => 'Logitech', 'slug' => 'logitech', 'country' => 'Suiza'],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }

        // 4. Productos de muestra
        $catLaptops = Category::where('slug', 'laptops-computadoras')->first()->id;
        $catPhones = Category::where('slug', 'smartphones')->first()->id;
        $catParts = Category::where('slug', 'repuestos-componentes')->first()->id;
        $catAcc = Category::where('slug', 'accesorios-perifericos')->first()->id;

        $brandSamsung = Brand::where('slug', 'samsung')->first()->id;
        $brandLenovo = Brand::where('slug', 'lenovo')->first()->id;
        $brandXiaomi = Brand::where('slug', 'xiaomi')->first()->id;
        $brandLogitech = Brand::where('slug', 'logitech')->first()->id;

        $products = [
            [
                'category_id' => $catLaptops,
                'brand_id' => $brandLenovo,
                'sku' => 'LAP-LEN-001',
                'name' => 'Laptop Lenovo IdeaPad Slim 3',
                'model' => '15IAH8',
                'description' => 'Intel Core i5, 16GB RAM, 512GB SSD, Pantalla 15.6 FHD',
                'purchase_price' => 1850.00,
                'sale_price' => 2290.00,
                'stock' => 12,
                'min_stock' => 3,
                'warranty_months' => 12,
            ],
            [
                'category_id' => $catPhones,
                'brand_id' => $brandSamsung,
                'sku' => 'CEL-SAM-001',
                'name' => 'Samsung Galaxy A55 5G',
                'model' => 'SM-A556E',
                'description' => '256GB Almacenamiento, 8GB RAM, Negro',
                'purchase_price' => 1150.00,
                'sale_price' => 1450.00,
                'stock' => 20,
                'min_stock' => 5,
                'warranty_months' => 12,
            ],
            [
                'category_id' => $catParts,
                'brand_id' => $brandSamsung,
                'sku' => 'REP-SAM-001',
                'name' => 'Unidad SSD NVMe M.2 1TB Samsung 980',
                'model' => 'MZ-V8V1T0B',
                'description' => 'Disco sólido interno PCIe 3.0 para laptops y PC',
                'purchase_price' => 240.00,
                'sale_price' => 320.00,
                'stock' => 4,
                'min_stock' => 5,
                'warranty_months' => 24,
            ],
            [
                'category_id' => $catAcc,
                'brand_id' => $brandLogitech,
                'sku' => 'ACC-LOG-001',
                'name' => 'Mouse Inalámbrico Logitech MX Master 3S',
                'model' => '910-006556',
                'description' => 'Sensor 8000 DPI, recargable USB-C, silencioso',
                'purchase_price' => 310.00,
                'sale_price' => 410.00,
                'stock' => 15,
                'min_stock' => 4,
                'warranty_months' => 12,
            ],
            [
                'category_id' => $catAcc,
                'brand_id' => $brandXiaomi,
                'sku' => 'ACC-XIA-001',
                'name' => 'Cargador Rápido Xiaomi 67W USB-C',
                'model' => 'MDY-12-EH',
                'description' => 'Incluye cable Tipo C de 6A original',
                'purchase_price' => 45.00,
                'sale_price' => 75.00,
                'stock' => 30,
                'min_stock' => 10,
                'warranty_months' => 6,
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['sku' => $prod['sku']], $prod);
        }
    }
}