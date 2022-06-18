<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleServicio extends Model
{
    use HasFactory;
    protected $table = 'detalle_servicios';
    protected $fillable = [
        'total_detalle',
        'id_servicio',
        'id_venta',

    ];

    public function venta(){
        return $this->belongsTo(Venta::class, 'id_venta', 'id');
    }

    public function servicio(){
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id');
    }
}
