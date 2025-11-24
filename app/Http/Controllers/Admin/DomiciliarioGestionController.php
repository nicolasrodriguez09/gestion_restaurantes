<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DomiciliarioGestionController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        $domiciliarios = User::query()
            ->where('role', 'domiciliario')
            ->select('id', 'name', 'email')
            ->withCount([
                'pedidosDomiciliario as entregas_totales' => fn($q) => $q->whereHas('estado', fn($e) => $e->where('nombreEstado', 'Entregado')),
                'pedidosDomiciliario as entregas_hoy' => fn($q) => $q->whereHas('estado', fn($e) => $e->where('nombreEstado', 'Entregado'))->whereDate('fechaPedido', $hoy),
            ])
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.domiciliarios.index', compact('domiciliarios'));
    }

    public function create()
    {
        return view('admin.domiciliarios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'domiciliario',
        ]);

        return redirect()->route('admin.domiciliarios.index')
            ->with('success', 'Domiciliario creado correctamente.');
    }

    public function show(User $domiciliario)
    {
        abort_unless($domiciliario->role === 'domiciliario', 404);

        $hoy = Carbon::today();

        $entregas = Pedido::with(['detalles.producto', 'estado'])
            ->where('id_domiciliario', $domiciliario->id)
            ->whereHas('estado', fn($e) => $e->where('nombreEstado', 'Entregado'))
            ->orderByDesc('fechaPedido')
            ->take(25)
            ->get();

        $entregasHoy = $entregas->whereBetween('fechaPedido', [$hoy->startOfDay(), $hoy->endOfDay()])->count();
        $totalEntregas = $entregas->count();

        return view('admin.domiciliarios.show', compact('domiciliario', 'entregas', 'entregasHoy', 'totalEntregas'));
    }

    public function edit(User $domiciliario)
    {
        abort_unless($domiciliario->role === 'domiciliario', 404);
        return view('admin.domiciliarios.edit', compact('domiciliario'));
    }

    public function update(Request $request, User $domiciliario)
    {
        abort_unless($domiciliario->role === 'domiciliario', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $domiciliario->id],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        $domiciliario->name = $data['name'];
        $domiciliario->email = $data['email'];
        if (!empty($data['password'])) {
            $domiciliario->password = Hash::make($data['password']);
        }
        $domiciliario->save();

        return redirect()->route('admin.domiciliarios.index')
            ->with('success', 'Domiciliario actualizado correctamente.');
    }

    public function destroy(User $domiciliario)
    {
        abort_unless($domiciliario->role === 'domiciliario', 404);
        $domiciliario->delete();

        return redirect()->route('admin.domiciliarios.index')
            ->with('success', 'Domiciliario eliminado.');
    }
}
