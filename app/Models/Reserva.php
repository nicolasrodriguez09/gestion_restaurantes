<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'nombreCliente',
        'telefonoCliente',
        'id_mesa',
        'fechaReserva',
        'id_estadoReserva',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'id_mesa');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoReserva::class, 'id_estadoReserva');
    }
}
