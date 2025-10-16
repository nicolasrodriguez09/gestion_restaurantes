<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelacionPedido extends Model
{
    protected $table = 'cancelacion_pedido';

    protected $fillable = [
        'id_pedido',
        'motivo',
        'fechaCancelacion',
        'autorizacion',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}
