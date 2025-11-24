<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;

class DomicilioController extends Controller
{
    public function index()
    {
        $domicilios = Pedido::with(['detalles.producto','estado'])
            ->whereHas('mesa', fn($q) => $q->where('numeroMesa', 9999))
            ->orderByDesc('fechaPedido')
            ->paginate(15);

        return view('admin.domicilios.index', compact('domicilios'));
    }
}
