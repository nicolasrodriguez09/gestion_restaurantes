<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MeseroGestionController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        $meseros = User::query()
            ->where('role', 'mesero')
            ->select('id', 'name', 'email')
            ->withCount([
                'pedidosMesero as pedidos_totales',
                'pedidosMesero as pedidos_hoy' => fn ($q) => $q->whereDate('fechaPedido', $hoy),
                'pedidosMesero as mesas_hoy' => fn ($q) => $q->select(DB::raw('COUNT(DISTINCT id_mesa)'))->whereDate('fechaPedido', $hoy),
            ])
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.meseros.index', compact('meseros'));
    }

    public function create()
    {
        return view('admin.meseros.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $mesero = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'mesero',
        ]);

        return redirect()->route('admin.meseros.index')
            ->with('success', 'Mesero creado correctamente.');
    }

    public function show(User $mesero)
    {
        abort_unless($mesero->role === 'mesero', 404);

        $hoy = Carbon::today();

        $pedidosHoy = Pedido::with(['mesa'])
            ->where('id_mesero', $mesero->id)
            ->whereDate('fechaPedido', $hoy)
            ->orderByDesc('fechaPedido')
            ->take(20)
            ->get();

        $totalMesasHoy = Pedido::where('id_mesero', $mesero->id)
            ->whereDate('fechaPedido', $hoy)
            ->distinct('id_mesa')
            ->count('id_mesa');

        $totalPedidosHoy = $pedidosHoy->count();

        return view('admin.meseros.show', compact('mesero', 'pedidosHoy', 'totalMesasHoy', 'totalPedidosHoy'));
    }

    public function edit(User $mesero)
    {
        abort_unless($mesero->role === 'mesero', 404);
        return view('admin.meseros.edit', compact('mesero'));
    }

    public function update(Request $request, User $mesero)
    {
        abort_unless($mesero->role === 'mesero', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $mesero->id],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        $mesero->name = $data['name'];
        $mesero->email = $data['email'];
        if (!empty($data['password'])) {
            $mesero->password = Hash::make($data['password']);
        }
        $mesero->save();

        return redirect()->route('admin.meseros.index')
            ->with('success', 'Mesero actualizado correctamente.');
    }

    public function destroy(User $mesero)
    {
        abort_unless($mesero->role === 'mesero', 404);

        $mesero->delete();

        return redirect()->route('admin.meseros.index')
            ->with('success', 'Mesero eliminado.');
    }
}
