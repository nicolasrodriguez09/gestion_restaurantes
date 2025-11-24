<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'id_mesero',
        'id_mesa',
        'id_estadoPedido',
        'fechaPedido',
        'totalPago',
        'stock_aplicado',
        'cliente_nombre',
        'cliente_telefono',
        'cliente_direccion',
        'cliente_nota',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'id_mesa');
    }

    public function mesero()
    {
        return $this->belongsTo(User::class, 'id_mesero');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoPedido::class, 'id_estadoPedido');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido');
    }
}
