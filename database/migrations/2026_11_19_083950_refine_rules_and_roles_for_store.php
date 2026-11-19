<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // RF01 y RN04: Rol de usuario (administrador o vendedor)
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol', 20)->default('vendedor')->after('password');
        });

        DB::statement("ALTER TABLE users ADD CONSTRAINT users_rol_check CHECK (rol IN ('administrador', 'vendedor'))");

        // RF03 y RF04: Tipo de producto (equipo_nuevo, repuesto, accesorio) e índices de búsqueda
        Schema::table('products', function (Blueprint $table) {
            $table->string('tipo', 20)->default('equipo_nuevo')->after('brand_id');
            $table->index(['category_id', 'brand_id', 'tipo'], 'products_filtros_index');
        });

        DB::statement("ALTER TABLE products ADD CONSTRAINT products_tipo_check CHECK (tipo IN ('equipo_nuevo', 'repuesto', 'accesorio'))");
        // RN01: El stock nunca puede quedar negativo en la base de datos
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_stock_nonnegative_check CHECK (stock >= 0)");
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_sale_price_positive_check CHECK (sale_price >= 0)");

        // RN03: Candados en el detalle de venta
        DB::statement("ALTER TABLE sale_details ADD CONSTRAINT sale_details_quantity_positive_check CHECK (quantity > 0)");
        DB::statement("ALTER TABLE sale_details ADD CONSTRAINT sale_details_unit_price_nonnegative_check CHECK (unit_price >= 0)");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE sale_details DROP CONSTRAINT IF EXISTS sale_details_unit_price_nonnegative_check');
        DB::statement('ALTER TABLE sale_details DROP CONSTRAINT IF EXISTS sale_details_quantity_positive_check');
        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_sale_price_positive_check');
        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_stock_nonnegative_check');
        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_tipo_check');

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_filtros_index');
            $table->dropColumn('tipo');
        });

        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_rol_check');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};