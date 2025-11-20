<?php

namespace App\Http\Controllers\Mesero;

use App\Http\Controllers\Controller;
use App\Models\DetallePedido;
use App\Models\EstadoPedido;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MeseroController extends Controller
{
    // Vista inicial: listado de mesas y pedidos en espera
    public function index()
    {
        $this->ensureEstadosBase();

        $mesas = Mesa::with(['estado', 'pedidos' => function ($q) {
            $q->latest()->limit(10);
        }])->orderBy('numeroMesa')->get();

        $estadoEnEspera = $this->estadoPorNombre(['espera', 'pend']);
        $pedidosPendientes = $estadoEnEspera
            ? Pedido::with(['mesa', 'mesero'])
                ->where('id_estadoPedido', $estadoEnEspera->id)
                ->orderBy('fechaPedido', 'asc')
                ->get()
            : collect();

        return view('mesero.index', compact('mesas', 'pedidosPendientes'));
    }

    // Detalle de una mesa: historial de pedidos
    public function show($id)
    {
        $this->ensureEstadosBase();
        $mesa = Mesa::with(['estado', 'pedidos.detalles.producto'])->findOrFail($id);

        $pedidos = $mesa->pedidos()
            ->with(['detalles.producto', 'mesero', 'estado'])
            ->latest()
            ->get();

        return view('mesero.show', compact('mesa', 'pedidos'));
    }

    // Pantalla para armar un nuevo pedido de la mesa (visualiza productos)
    public function crearPedido($id)
    {
        $this->ensureEstadosBase();
        $mesa = Mesa::with('estado')->findOrFail($id);

        $productos = Producto::where('disponibilidad', '>', 0)
            ->orderBy('nombreProducto')
            ->get();

        return view('mesero.pedidos.crear', compact('mesa', 'productos'));
    }

    // Helper: obtener o crear pedido abierto (en espera) para la mesa
    protected function getOrCreatePedidoAbierto(Mesa $mesa)
    {
        $estadoEnEspera = $this->estadoPorNombre(['espera', 'pend']);
        if (!$estadoEnEspera) {
            abort(400, 'No se encontro estado de espera para pedidos.');
        }

        $pedido = $mesa->pedidos()
            ->where('id_estadoPedido', $estadoEnEspera->id)
            ->latest()
            ->first();

        if (!$pedido) {
            $pedido = $mesa->pedidos()->create([
                'id_estadoPedido' => $estadoEnEspera->id,
                'fechaPedido'     => now(),
                'id_mesero'       => Auth::id(),
                'totalPago'       => 0,
            ]);
        }

        return $pedido;
    }

    // POST: agregar producto (con cantidad) al pedido abierto de la mesa
    public function agregarProducto(Request $request, $id)
    {
        $this->ensureEstadosBase();

        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $mesa = Mesa::findOrFail($id);
        $producto = Producto::findOrFail($data['producto_id']);

        if ((int) $producto->disponibilidad < $data['cantidad']) {
            return back()->with('error', 'No hay stock suficiente de este producto.');
        }

        DB::transaction(function () use ($mesa, $producto, $data) {
            $pedido = $this->getOrCreatePedidoAbierto($mesa);

            $detalle = $pedido->detalles()->firstOrNew([
                'id_producto' => $producto->id,
            ]);

            $detalle->id_pedido      = $pedido->id;
            $detalle->precioUnitario = $producto->precio;
            $detalle->cantidad       = ($detalle->exists ? $detalle->cantidad : 0) + $data['cantidad'];
            $detalle->subTotal       = $detalle->cantidad * $detalle->precioUnitario;
            $detalle->save();

            $pedido->totalPago = $pedido->detalles()->sum('subTotal');
            $pedido->save();

            $producto->decrement('disponibilidad', $data['cantidad']);
        });

        return back()->with('ok', 'Producto agregado al pedido.');
    }

    // POST: actualizar cantidad de un detalle en pedido en espera
    public function actualizarDetalle(Request $request, $mesaId, DetallePedido $detalle)
    {
        $this->ensureEstadosBase();

        $data = $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $mesa = Mesa::findOrFail($mesaId);
        $pedido = $detalle->pedido;

        if ($pedido->id_mesa !== $mesa->id) {
            abort(403);
        }

        $estadoEnEspera = $this->estadoPorNombre(['espera', 'pend']);
        if (!$estadoEnEspera || $pedido->id_estadoPedido !== $estadoEnEspera->id) {
            return back()->with('error', 'Solo puedes modificar pedidos en espera.');
        }

        $producto = $detalle->producto;
        $cantidadAnterior = $detalle->cantidad;
        $nuevaCantidad = $data['cantidad'];
        $diferencia = $nuevaCantidad - $cantidadAnterior;

        if ($diferencia > 0 && $producto->disponibilidad < $diferencia) {
            return back()->with('error', 'No hay stock suficiente para aumentar la cantidad.');
        }

        DB::transaction(function () use ($detalle, $producto, $diferencia, $nuevaCantidad) {
            if ($diferencia > 0) {
                $producto->decrement('disponibilidad', $diferencia);
            } elseif ($diferencia < 0) {
                $producto->increment('disponibilidad', abs($diferencia));
            }

            $detalle->cantidad = $nuevaCantidad;
            $detalle->subTotal = $detalle->cantidad * $detalle->precioUnitario;
            $detalle->save();

            $pedido = $detalle->pedido;
            $pedido->totalPago = $pedido->detalles()->sum('subTotal');
            $pedido->save();
        });

        return back()->with('ok', 'Detalle actualizado.');
    }

    // POST: cancelar pedido en espera (restaura stock y borra)
    public function cancelarPedido($mesaId)
    {
        $this->ensureEstadosBase();

        $mesa = Mesa::findOrFail($mesaId);
        $estadoEnEspera = $this->estadoPorNombre(['espera', 'pend']);
        if (!$estadoEnEspera) {
            return back()->with('error', 'No hay estado de espera configurado.');
        }

        $pedido = $mesa->pedidos()->where('id_estadoPedido', $estadoEnEspera->id)->latest()->first();
        if (!$pedido) {
            return back()->with('error', 'No hay pedido en espera para cancelar.');
        }

        DB::transaction(function () use ($pedido) {
            foreach ($pedido->detalles as $detalle) {
                if ($detalle->producto) {
                    $detalle->producto->increment('disponibilidad', $detalle->cantidad);
                }
            }
            $pedido->detalles()->delete();
            $pedido->delete();
        });

        return back()->with('ok', 'Pedido cancelado y stock restaurado.');
    }

    // POST: cerrar pedido (marcar entregado)
    public function cerrarPedido($mesaId)
    {
        $this->ensureEstadosBase();

        $mesa = Mesa::findOrFail($mesaId);
        $estadoListo = $this->estadoPorNombre(['listo', 'entrega', 'final']);
        $estadoEnProceso = $this->estadoPorNombre(['proceso', 'curso', 'prep']);

        $pedido = $mesa->pedidos()
            ->when($estadoEnProceso, fn($q) => $q->where('id_estadoPedido', $estadoEnProceso->id))
            ->when($estadoListo, fn($q) => $q->orWhere('id_estadoPedido', $estadoListo->id))
            ->latest()
            ->first();

        if (!$pedido) {
            return back()->with('error', 'No hay pedido listo para cerrar.');
        }

        $estadoEntregado = EstadoPedido::firstOrCreate(
            ['nombreEstado' => 'Entregado'],
            ['descripcion' => 'Pedido entregado al cliente']
        );

        $pedido->id_estadoPedido = $estadoEntregado->id;
        $pedido->save();

        return back()->with('ok', 'Pedido marcado como entregado.');
    }

    /**
     * Obtiene un estado de pedido cuyo nombre contenga alguna palabra clave.
     */
    protected function estadoPorNombre(array $keywords): ?EstadoPedido
    {
        return EstadoPedido::all()
            ->first(function ($estado) use ($keywords) {
                $nombre = Str::lower($estado->nombreEstado ?? '');
                foreach ($keywords as $kw) {
                    if (Str::contains($nombre, Str::lower($kw))) {
                        return true;
                    }
                }
                return false;
            });
    }

    /**
     * Asegura que existan los estados base para operar pedidos.
     */
    protected function ensureEstadosBase(): void
    {
        $base = ['En espera', 'En proceso', 'Listo', 'Entregado'];
        foreach ($base as $nombre) {
            EstadoPedido::firstOrCreate(
                ['nombreEstado' => $nombre],
                ['descripcion' => $nombre]
            );
        }
    }
}
