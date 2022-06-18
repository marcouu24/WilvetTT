<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $fillable = [
        'id_usuario',
        'rut_cliente',
        'fecha_venta',
        'total_venta',

    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'rut_cliente', 'rut');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    public function detalle_ventas(){
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id');
    }

    public function detalle_servicios(){
        return $this->hasMany(DetalleServicio::class, 'id_venta', 'id');
    }
}
