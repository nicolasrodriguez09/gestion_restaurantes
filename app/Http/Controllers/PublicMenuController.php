<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\EstadoMesa;
use App\Models\EstadoPedido;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublicMenuController extends Controller
{
    public function index()
    {
        $productos = Producto::where('disponibilidad', '>', 0)->orderBy('nombreProducto')->get();

        return view('menu', [
            'productos' => $productos,
            'comidas' => $productos->reject(fn($p) => str_contains(strtolower($p->categoria ?? ''), 'bebida')),
            'bebidas' => $productos->filter(fn($p) => str_contains(strtolower($p->categoria ?? ''), 'bebida')),
        ]);
    }

    public function domicilio()
    {
        $productos = Producto::where('disponibilidad', '>', 0)->orderBy('nombreProducto')->get();

        return view('menu-domicilio', [
            'productos' => $productos,
            'comidas' => $productos->reject(fn($p) => str_contains(strtolower($p->categoria ?? ''), 'bebida')),
            'bebidas' => $productos->filter(fn($p) => str_contains(strtolower($p->categoria ?? ''), 'bebida')),
            'originLat' => config('services.maps.origin_lat'),
            'originLng' => config('services.maps.origin_lng'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:120',
            'telefono' => 'required|string|max:30',
            'direccion' => 'required|string|max:255',
            'nota' => 'nullable|string|max:255',
            'cantidad' => 'required|array',
            'cliente_lat' => 'required|numeric',
            'cliente_lng' => 'required|numeric',
            'cliente_place_id' => 'nullable|string|max:255',
        ]);

        $cantidades = collect($request->input('cantidad'))
            ->filter(fn($qty) => (int)$qty > 0)
            ->map(fn($qty) => (int)$qty);

        if ($cantidades->isEmpty()) {
            return back()->with('error', 'Agrega al menos un producto.')->withInput();
        }

        $productos = Producto::whereIn('id', $cantidades->keys())->get();
        if ($productos->count() !== $cantidades->count()) {
            return back()->with('error', 'Alguno de los productos no existe.')->withInput();
        }

        foreach ($productos as $prod) {
            if ($prod->disponibilidad < $cantidades[$prod->id]) {
                return back()->with('error', 'Stock insuficiente para '.$prod->nombreProducto.'.')->withInput();
            }
        }

        DB::transaction(function () use ($request, $productos, $cantidades) {
            $estadoMesa = EstadoMesa::firstOrCreate(
                ['nombreEstado' => 'Libre'],
                ['descripcion' => 'Mesa disponible']
            );

            $mesaDomicilio = Mesa::firstOrCreate(
                ['numeroMesa' => 9999],
                ['capacidad' => 0, 'ubicacion' => 'Domicilios', 'id_estado' => $estadoMesa->id]
            );

            $estadoPedido = EstadoPedido::firstOrCreate(
                ['nombreEstado' => 'En espera'],
                ['descripcion' => 'Pedido en espera']
            );

            $meseroAsignado = User::where('role', 'mesero')->first() ?? User::first();
            if (!$meseroAsignado) {
                throw new \RuntimeException('No hay usuario para asignar el pedido.');
            }

            $pedido = Pedido::create([
                'id_mesero' => $meseroAsignado->id,
                'id_mesa' => $mesaDomicilio->id,
                'id_estadoPedido' => $estadoPedido->id,
                'fechaPedido' => now(),
                'totalPago' => 0,
                'stock_aplicado' => false,
                'cliente_nombre' => $request->nombre,
                'cliente_telefono' => $request->telefono,
                'cliente_direccion' => $request->direccion,
                'cliente_nota' => $request->nota,
                'cliente_lat' => $request->cliente_lat,
                'cliente_lng' => $request->cliente_lng,
                'cliente_place_id' => $request->cliente_place_id,
            ]);

            $total = 0;
            foreach ($productos as $prod) {
                $cantidad = $cantidades[$prod->id];
                $subtotal = $cantidad * $prod->precio;
                DetallePedido::create([
                    'id_pedido' => $pedido->id,
                    'id_producto' => $prod->id,
                    'cantidad' => $cantidad,
                    'precioUnitario' => $prod->precio,
                    'subTotal' => $subtotal,
                ]);
                $total += $subtotal;
            }

            $pedido->totalPago = $total;
            $pedido->save();
        });

        return back()->with('ok', 'Pedido enviado. Cocina fue notificada.');
    }
}
