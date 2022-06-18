<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compras';
    protected $fillable = [
        'fecha_compra',
        'total_compra',
        'id_usuario',
        'id_proveedor',

    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id');
    }

    public function detalle_compras(){
        return $this->hasMany(DetalleCompra::class, 'id_compra', 'id');
    }

    
}
