<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'mesas';

    protected $fillable = [
        'numeroMesa',
        'capacidad',
        'ubicacion',
        'id_estado',
    ];

    public function estado()
    {
        return $this->belongsTo(EstadoMesa::class, 'id_estado');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_mesa');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_mesa');
    }
}
