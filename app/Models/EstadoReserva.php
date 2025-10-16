<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoReserva extends Model
{
    protected $table = 'estado_reserva';

    protected $fillable = ['nombreEstado', 'descripcion'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_estadoReserva');
    }
}
