<?php

namespace App\Http\Controllers\Domiciliario;

use App\Http\Controllers\Controller;
use App\Models\EstadoPedido;
use App\Models\Mesa;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DomiciliarioController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['detalles.producto','estado'])
            ->whereHas('mesa', fn($q) => $q->where('numeroMesa', 9999))
            ->orderByDesc('fechaPedido')
            ->get();

        return view('domiciliario.dashboard', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['detalles.producto','estado'])
            ->whereHas('mesa', fn($q) => $q->where('numeroMesa', 9999))
            ->findOrFail($id);

        return view('domiciliario.show', compact('pedido'));
    }

    public function entregar(Request $request, $id)
    {
        $pedido = Pedido::whereHas('mesa', fn($q) => $q->where('numeroMesa', 9999))
            ->findOrFail($id);

        $estadoEntregado = EstadoPedido::firstOrCreate(
            ['nombreEstado' => 'Entregado'],
            ['descripcion' => 'Pedido entregado']
        );

        $pedido->id_estadoPedido = $estadoEntregado->id;
        $pedido->id_domiciliario = auth()->id();
        $pedido->stock_aplicado = true;
        $pedido->save();

        return back()->with('ok', 'Pedido marcado como entregado.');
    }
}
