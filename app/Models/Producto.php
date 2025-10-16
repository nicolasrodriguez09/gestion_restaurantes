<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombreProducto',
        'descripcion',
        'precio',
        'categoria',
        'disponibilidad',
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_producto');
    }
}

