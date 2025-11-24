<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CocinaController extends Controller
{
    public function index()
    {
        $estados = EstadoPedido::all()->keyBy('id');

        $catEsperando = $estados->filter(fn ($e) => Str::contains(Str::lower($e->nombreEstado), ['espera', 'pend']));
        $catProceso = $estados->filter(fn ($e) => Str::contains(Str::lower($e->nombreEstado), ['proceso', 'curso', 'prep']));
        $catListo = $estados->filter(fn ($e) => Str::contains(Str::lower($e->nombreEstado), ['listo', 'entrega', 'final']));
        $catEntregado = $estados->filter(fn ($e) => Str::contains(Str::lower($e->nombreEstado), ['entreg']));

        $pedidos = Pedido::with(['mesa', 'estado', 'detalles.producto'])
            ->whereIn('id_estadoPedido', $estados->keys())
            ->orderByDesc('fechaPedido')
            ->get();

        $espera = $pedidos->whereIn('id_estadoPedido', $catEsperando->keys());
        $proceso = $pedidos->whereIn('id_estadoPedido', $catProceso->keys());
        $entregados = $pedidos->whereIn('id_estadoPedido', $catEntregado->keys());
        $listo = $pedidos->whereIn('id_estadoPedido', $catListo->keys())->reject(fn($p) => $entregados->contains('id', $p->id));

        return view('admin.cocina.index', compact('espera', 'proceso', 'listo', 'entregados', 'catEsperando', 'catProceso', 'catListo', 'catEntregado'));
    }

    public function cambiarEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado_id' => 'required|exists:estado_pedido,id',
        ]);

        $estadoActual = Str::lower($pedido->estado->nombreEstado ?? '');
        if (Str::contains($estadoActual, ['entreg'])) {
            return back()->with('error', 'No se puede mover un pedido ya entregado.');
        }

        $estadoDestino = EstadoPedido::findOrFail($request->estado_id);
        $destinoLower = Str::lower($estadoDestino->nombreEstado);

        if ((Str::contains($destinoLower, ['proceso', 'curso', 'prep'])) && !$pedido->stock_aplicado) {
            $pedido->load('detalles.producto');
            foreach ($pedido->detalles as $detalle) {
                if ($detalle->producto && $detalle->producto->disponibilidad < $detalle->cantidad) {
                    return back()->with('error', 'Stock insuficiente para ' . ($detalle->producto->nombreProducto ?? 'producto') . '.');
                }
            }
            foreach ($pedido->detalles as $detalle) {
                if ($detalle->producto) {
                    $detalle->producto->decrement('disponibilidad', $detalle->cantidad);
                }
            }
            $pedido->stock_aplicado = true;
        }

        $pedido->id_estadoPedido = $request->estado_id;
        $pedido->save();

        return back()->with('ok', 'Estado actualizado.');
    }
}
