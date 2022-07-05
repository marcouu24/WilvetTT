<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $table = 'detalle_compras';
    public $timestamps = false;
    protected $fillable = [
        'cantidad',
        'total_detalle',
        'precio_unitario',
        'id_compra',
        'id_producto',

    ];

    public function compra(){
        return $this->belongsTo(Compra::class, 'id_compra', 'id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'id_producto', 'id');
    }
   
}
