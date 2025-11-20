<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo producto</h2>
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

        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nombre</label>
                <input type="text" name="nombreProducto" value="{{ old('nombreProducto') }}" class="mt-1 w-full border rounded px-3 py-2" required maxlength="120">
            </div>

            <div>
                <label class="block text-sm font-medium">Descripcion</label>
                <textarea name="descripcion" rows="3" class="mt-1 w-full border rounded px-3 py-2">{{ old('descripcion') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Precio</label>
                <input type="number" name="precio" value="{{ old('precio') }}" class="mt-1 w-full border rounded px-3 py-2" step="0.01" min="0" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Categoria</label>
                <input type="text" name="categoria" value="{{ old('categoria') }}" class="mt-1 w-full border rounded px-3 py-2" maxlength="60" placeholder="Bebidas, Platos, Postres...">
            </div>

            <div>
                <label class="block text-sm font-medium">Disponibilidad (unidades)</label>
                <input type="number" name="disponibilidad" value="{{ old('disponibilidad', 0) }}" class="mt-1 w-full border rounded px-3 py-2" min="0" required>
                <p class="text-xs text-gray-500 mt-1">Cantidad de unidades disponibles para venta.</p>
            </div>

            <div>
                <label class="block text-sm font-medium">Imagen del producto</label>
                <input type="file" name="imagen" accept="image/*" class="mt-1 w-full border rounded px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">Opcional. JPG/PNG hasta 2MB.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.productos.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
