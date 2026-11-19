<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Contraseña para ambos usuarios: password
        User::factory()->administrador()->create([
            'name'  => 'Administrador Tienda',
            'email' => 'admin@tienda.test',
        ]);

        User::factory()->create([
            'name'  => 'Carlos Vendedor',
            'email' => 'vendedor@tienda.test',
            'rol'   => 'vendedor',
        ]);
    }
}