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
        $baseQuery = Pedido::with(['detalles.producto','estado'])
            ->whereHas('mesa', fn($q) => $q->where('numeroMesa', 9999))
            ->orderByDesc('fechaPedido');

        $pendientes = (clone $baseQuery)
            ->whereDoesntHave('estado', fn($e) => $e->where('nombreEstado', 'Entregado'))
            ->get();

        $entregados = (clone $baseQuery)
            ->whereHas('estado', fn($e) => $e->where('nombreEstado', 'Entregado'))
            ->get();

        return view('domiciliario.dashboard', compact('pendientes', 'entregados'));
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
        $pedido = Pedido::with('estado')
            ->whereHas('mesa', fn($q) => $q->where('numeroMesa', 9999))
            ->findOrFail($id);

        $estadoActual = strtolower($pedido->estado->nombreEstado ?? '');

        if (str_contains($estadoActual, 'entreg')) {
            return back()->with('error', 'Este pedido ya fue marcado como entregado.');
        }

        if (!str_contains($estadoActual, 'listo')) {
            return back()->with('error', 'Solo puedes marcar como entregado un pedido en estado listo.');
        }

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
