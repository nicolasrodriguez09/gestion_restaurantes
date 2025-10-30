<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombreProducto')->paginate(10);
        return view('admin.productos.index', compact('productos'));
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
        return redirect()->route('admin.productos.index')->with('success','Producto creado');
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
        return redirect()->route('admin.productos.index')->with('success','Producto actualizado');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('success','Producto eliminado');
    }
}
