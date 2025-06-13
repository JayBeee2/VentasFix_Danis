<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sku',
        'nombre',
        'descripcion_corta',
        'descripcion_larga',
        'imagen',
        'precio_neto',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'stock_bajo',
        'stock_alto'
    ];
    
    // Método para calcular el precio de venta automáticamente
    public function setPrecioNetoAttribute($value)
    {
        $this->attributes['precio_neto'] = $value;
        // Calcular precio de venta con IVA (19%)
        $this->attributes['precio_venta'] = $value * 1.19;
    }
}
