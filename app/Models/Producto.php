<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'precio_venta',
        'stock',
        'id_categoria',

    ];

    public function detalle_compras(){
        return $this->hasMany(DetalleCompra::class, 'id_producto', 'id');
    }

    public function detalle_ventas(){
        return $this->hasMany(DetalleVenta::class, 'id_producto', 'id');
    }

    public function ajustes(){
        return $this->hasMany(Ajuste::class, 'id_producto', 'id');
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id');
    }
}
