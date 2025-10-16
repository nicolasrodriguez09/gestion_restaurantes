<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model
{
    protected $table = 'estado_pedido';

    protected $fillable = ['nombreEstado', 'descripcion'];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_estadoPedido');
    }
}
