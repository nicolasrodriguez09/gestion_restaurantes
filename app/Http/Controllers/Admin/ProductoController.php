<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('buscar');

        $productos = Producto::query()
            ->when($q, function ($query) use ($q) {
                $query->where('nombreProducto', 'like', "%{$q}%")
                      ->orWhere('categoria', 'like', "%{$q}%");
            })
            ->orderBy('nombreProducto')
            ->paginate(10)
            ->withQueryString();

        return view('admin.productos.index', compact('productos', 'q'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombreProducto' => ['required','string','max:120'],
            'descripcion'    => ['nullable','string'],
            'precio'         => ['required','numeric','min:0'],
            'categoria'      => ['nullable','string','max:60'],
            'disponibilidad' => ['required','boolean'],
        ]);

        Producto::create($data);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function edit(Producto $producto)
    {
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombreProducto' => ['required','string','max:120'],
            'descripcion'    => ['nullable','string'],
            'precio'         => ['required','numeric','min:0'],
            'categoria'      => ['nullable','string','max:60'],
            'disponibilidad' => ['required','boolean'],
        ]);

        $producto->update($data);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado');
    }
}
