<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';


    
    public $incrementing = false;
    protected $keyType = 'string';


    protected $primaryKey = 'rut';


    protected $fillable = [
        'rut',
        'nombre',
        'comuna',
        'direccion',
        'telefono',
        'email',
    ];

    public function ventas(){
        return $this->hasMany(Venta::class, 'rut_cliente', 'rut');
    }
}
