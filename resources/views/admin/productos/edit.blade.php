<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar producto</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded p-6 space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium">Nombre</label>
                <input type="text" name="nombreProducto" value="{{ old('nombreProducto', $producto->nombreProducto) }}" class="mt-1 w-full border rounded px-3 py-2" required maxlength="120">
            </div>

            <div>
                <label class="block text-sm font-medium">Descripcion</label>
                <textarea name="descripcion" rows="3" class="mt-1 w-full border rounded px-3 py-2">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Precio</label>
                <input type="number" name="precio" value="{{ old('precio', $producto->precio) }}" class="mt-1 w-full border rounded px-3 py-2" step="0.01" min="0" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Categoria</label>
                <input type="text" name="categoria" value="{{ old('categoria', $producto->categoria) }}" class="mt-1 w-full border rounded px-3 py-2" maxlength="60">
            </div>

            <div>
                <label class="block text-sm font-medium">Disponibilidad (unidades)</label>
                <input type="number" name="disponibilidad" value="{{ old('disponibilidad', (int)$producto->disponibilidad) }}" class="mt-1 w-full border rounded px-3 py-2" min="0" required>
                <p class="text-xs text-gray-500 mt-1">Cantidad de unidades disponibles para venta.</p>
            </div>

            <div>
                <label class="block text-sm font-medium">Imagen del producto</label>
                <input type="file" name="imagen" accept="image/*" class="mt-1 w-full border rounded px-3 py-2">
                @if ($producto->imagen)
                    <p class="text-xs text-gray-500 mt-1">Imagen actual:</p>
                    <img src="{{ asset('storage/'.$producto->imagen) }}" alt="Imagen {{ $producto->nombreProducto }}" class="mt-2 h-24 w-24 rounded object-cover border">
                @endif
                <p class="text-xs text-gray-500 mt-1">Si subes una nueva, reemplazara la existente. Max 2MB.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.productos.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
