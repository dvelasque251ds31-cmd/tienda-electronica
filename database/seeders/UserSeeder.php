<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Contraseña para ambos usuarios: 123456
        User::factory()->administrador()->create([
            'name'  => 'Administrador Tienda',
            'email' => 'admin',
        ]);

        User::factory()->create([
            'name'  => 'Carlos Vendedor',
            'email' => 'vendedor',
            'rol'   => 'vendedor',
        ]);
    }
}