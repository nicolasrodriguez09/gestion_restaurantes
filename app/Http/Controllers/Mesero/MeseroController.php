<?php

namespace App\Http\Controllers\Mesero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\EstadoPedido;
use App\Models\Producto;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeseroController extends Controller
{
    // === Vista inicial: listado de mesas y pedidos en espera ===
    public function index()
    {
        // Todas las mesas con su estado y pedidos recientes
        $mesas = Mesa::with(['estado', 'pedidos' => function($q) {
            $q->latest()->limit(10);
        }])->orderBy('numeroMesa')->get();

        // Pedidos en estado "en_espera"
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

    // === Detalle de una mesa: historial de pedidos ===
    public function show($id)
    {
        $mesa = Mesa::with(['estado','pedidos.detalles.producto'])->findOrFail($id);

        // Pedidos recientes de la mesa
        $pedidos = $mesa->pedidos()
            ->with(['detalles.producto','mesero','estado'])
            ->latest()
            ->get();

        return view('mesero.show', compact('mesa','pedidos'));
    }

    // === Pantalla para armar un nuevo pedido de la mesa (visualiza productos) ===
    public function crearPedido($id)
    {
        $mesa = Mesa::with('estado')->findOrFail($id);

        // Productos disponibles (ajusta filtro si manejas disponibilidad)
        $productos = Producto::orderBy('nombreProducto')->get();

        return view('mesero.pedidos.crear', compact('mesa', 'productos'));
    }

    // === Helper: obtener o crear pedido "abierto" (en_espera) para la mesa ===
    protected function getOrCreatePedidoAbierto(Mesa $mesa)
    {
        // Ajusta el nombre del estado si en tu BD es distinto
        $estadoEnEspera = EstadoPedido::where('nombreEstado', 'en_espera')->firstOrFail();

        // Buscar si ya hay un pedido abierto para esta mesa
        $pedido = $mesa->pedidos()
            ->where('id_estadoPedido', $estadoEnEspera->id)
            ->latest()
            ->first();

        if (!$pedido) {
            $pedido = $mesa->pedidos()->create([
                'id_estadoPedido' => $estadoEnEspera->id,
                'fechaPedido'     => now(),
                'id_mesero'       => Auth::id(), // cambia el nombre de la columna si usas otra
                'totalPago'       => 0,
            ]);
        }

        return $pedido;
    }

    // === POST: agregar producto (con cantidad) al pedido abierto de la mesa ===
    public function agregarProducto(Request $request, $id)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $mesa = Mesa::findOrFail($id);
        $producto = Producto::findOrFail($data['producto_id']);

        
        if (!$producto->disponibilidad) {
             return back()->with('error', 'El producto no está disponible.');
        }

        DB::transaction(function () use ($mesa, $producto, $data) {
            $pedido = $this->getOrCreatePedidoAbierto($mesa);

            // Reutiliza el detalle si ya existe el mismo producto
            $detalle = $pedido->detalles()->firstOrNew([
                'id_producto' => $producto->id,
            ]);

            $detalle->id_pedido      = $pedido->id; // por si firstOrNew no lo estableció
            $detalle->precioUnitario = $producto->precio;
            $detalle->cantidad       = ($detalle->exists ? $detalle->cantidad : 0) + $data['cantidad'];
            $detalle->subTotal       = $detalle->cantidad * $detalle->precioUnitario;
            $detalle->save();

            // Recalcular total del pedido
            $pedido->totalPago = $pedido->detalles()->sum('subTotal');
            $pedido->save();
        });

        return back()->with('ok', 'Producto agregado al pedido.');
    }
}
