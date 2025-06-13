<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        // Crear algunos productos de prueba
        \App\Models\Product::create([
            'sku' => 'PROD-001',
            'nombre' => 'Producto de Prueba 1',
            'descripcion_corta' => 'Descripción corta del producto 1',
            'descripcion_larga' => 'Esta es una descripción más detallada del producto 1 para mostrar en la vista de detalles.',
            'precio_neto' => 10000,
            'precio_venta' => 11900,
            'stock_actual' => 20,
            'stock_minimo' => 5,
            'stock_bajo' => 10,
            'stock_alto' => 30
        ]);
        
        \App\Models\Product::create([
            'sku' => 'PROD-002',
            'nombre' => 'Producto de Prueba 2',
            'descripcion_corta' => 'Descripción corta del producto 2',
            'descripcion_larga' => 'Esta es una descripción más detallada del producto 2 para mostrar en la vista de detalles.',
            'precio_neto' => 15000,
            'precio_venta' => 17850,
            'stock_actual' => 8,
            'stock_minimo' => 10,
            'stock_bajo' => 15,
            'stock_alto' => 40
        ]);
        
        \App\Models\Product::create([
            'sku' => 'PROD-003',
            'nombre' => 'Producto de Prueba 3',
            'descripcion_corta' => 'Descripción corta del producto 3',
            'descripcion_larga' => 'Esta es una descripción más detallada del producto 3 para mostrar en la vista de detalles.',
            'precio_neto' => 25000,
            'precio_venta' => 29750,
            'stock_actual' => 50,
            'stock_minimo' => 10,
            'stock_bajo' => 20,
            'stock_alto' => 60
        ]);
    }
}
