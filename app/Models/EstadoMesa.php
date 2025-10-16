<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoMesa extends Model
{
    protected $table = 'estado_mesa';

    protected $fillable = ['nombreEstado', 'descripcion'];

    public function mesas()
    {
        return $this->hasMany(Mesa::class, 'id_estado');
    }
}
