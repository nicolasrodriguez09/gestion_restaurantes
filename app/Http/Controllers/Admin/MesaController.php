<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = \App\Models\Mesa::with('estado')
            ->orderBy('numeroMesa')
            ->paginate(10);

        return view('admin.mesas.index', compact('mesas'));
    }

    public function create()
    {
        // [id => nombreEstado]
        $estados = DB::table('estado_mesa')->pluck('nombreEstado', 'id');
        return view('admin.mesas.create', compact('estados'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numeroMesa' => ['required','integer','min:1','unique:mesas,numeroMesa'],
            'capacidad'  => ['required','integer','min:1','max:50'],
            'ubicacion'  => ['nullable','string','max:100'],
            'id_estado'  => ['required','exists:estado_mesa,id'],
        ]);

        Mesa::create($data);
        return redirect()->route('admin.mesas.index')->with('success','Mesa creada correctamente');
    }

    public function edit(Mesa $mesa)
    {
        $estados = DB::table('estado_mesa')->pluck('nombreEstado', 'id');
        return view('admin.mesas.edit', compact('mesa','estados'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $data = $request->validate([
            'numeroMesa' => [
                'required','integer','min:1',
                Rule::unique('mesas','numeroMesa')->ignore($mesa->id)
            ],
            'capacidad'  => ['required','integer','min:1','max:50'],
            'ubicacion'  => ['nullable','string','max:100'],
            'id_estado'  => ['required','exists:estado_mesa,id'],
        ]);

        $mesa->update($data);
        return redirect()->route('admin.mesas.index')->with('success','Mesa actualizada');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();
        return redirect()->route('admin.mesas.index')->with('success','Mesa eliminada');
    }
}
