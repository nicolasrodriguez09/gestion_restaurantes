<?php

namespace App\Http\Controllers\Mesero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\EstadoPedido;
use Illuminate\Support\Facades\Auth;

class MeseroController extends Controller
{
    // funcion de vista inicial
    public function index()
    {
        // Todas las mesas con su estado y pedidos recientes
        $mesas = Mesa::with(['estado', 'pedidos' => function($q) {
            $q->latest()->limit(10);
        }])->orderBy('numeroMesa')->get();

        // estado de pedidos
        $estadoEnEspera = EstadoPedido::where('nombreEstado', 'en_espera')->first();
        $pedidosPendientes = collect();
        if ($estadoEnEspera) {
            $pedidosPendientes = Pedido::with(['mesa','mesero'])
                ->where('id_estadoPedido', $estadoEnEspera->id)
                ->orderBy('fechaPedido', 'asc')
                ->get();
        }

        return view('mesero.index', compact('mesas', 'pedidosPendientes'));
    }

    // detalles
    public function show($id)
    {
        $mesa = Mesa::with(['estado','pedidos.detalles.producto'])->findOrFail($id);

        // Pedidos recientes de la mesa
        $pedidos = $mesa->pedidos()->with(['detalles.producto','mesero','estado'])->latest()->get();

        return view('mesero.show', compact('mesa','pedidos'));
    }
}
