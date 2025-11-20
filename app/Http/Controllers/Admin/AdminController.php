<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstadoMesa;
use App\Models\EstadoPedido;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\Producto;

class AdminController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();
        $productosConStock = Producto::where('disponibilidad', '>', 0)->count();
        $unidadesDisponibles = Producto::sum('disponibilidad');

        $mesasTotales = Mesa::count();
        $idsOcupadas = EstadoMesa::whereRaw('LOWER(nombreEstado) LIKE ?', ['%ocup%'])->pluck('id');
        $mesasOcupadas = $idsOcupadas->isNotEmpty()
            ? Mesa::whereIn('id_estado', $idsOcupadas)->count()
            : 0;
        $porcentajeOcupacion = $mesasTotales > 0
            ? round(($mesasOcupadas / $mesasTotales) * 100, 0)
            : 0;

        $idsEstadosActivos = EstadoPedido::where(function ($q) {
            $q->whereRaw('LOWER(nombreEstado) LIKE ?', ['%activo%'])
              ->orWhereRaw('LOWER(nombreEstado) LIKE ?', ['%curso%'])
              ->orWhereRaw('LOWER(nombreEstado) LIKE ?', ['%proceso%'])
              ->orWhereRaw('LOWER(nombreEstado) LIKE ?', ['%pend%']);
        })->pluck('id');

        $pedidosActivos = $idsEstadosActivos->isNotEmpty()
            ? Pedido::whereIn('id_estadoPedido', $idsEstadosActivos)->count()
            : Pedido::count();

        return view('admin.dashboard', [
            'totalProductos' => $totalProductos,
            'productosConStock' => $productosConStock,
            'unidadesDisponibles' => $unidadesDisponibles,
            'mesasTotales' => $mesasTotales,
            'mesasOcupadas' => $mesasOcupadas,
            'porcentajeOcupacion' => $porcentajeOcupacion,
            'pedidosActivos' => $pedidosActivos,
        ]);
    }
}
