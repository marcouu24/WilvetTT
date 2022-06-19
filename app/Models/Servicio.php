<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicios';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'valor_servicio',

    ];

    public function detalle_servicios(){
        return $this->hasMany(DetalleServicio::class, 'id_servicio', 'id');
    }
}
