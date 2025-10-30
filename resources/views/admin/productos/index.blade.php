<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Productos</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <form method="GET" action="{{ route('admin.productos.index') }}" class="flex gap-2">
                <input name="buscar" value="{{ $q }}" class="border rounded px-2 py-1"
                       placeholder="Buscar por nombre o categoría...">
                <button class="bg-gray-800 text-white px-3 py-1 rounded">Buscar</button>
            </form>

            <a href="{{ route('admin.productos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Nuevo producto
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-3">Nombre</th>
                        <th class="text-left p-3">Categoría</th>
                        <th class="text-left p-3">Precio</th>
                        <th class="text-left p-3">Disponible</th>
                        <th class="text-left p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($productos as $p)
                    <tr class="border-t">
                        <td class="p-3">{{ $p->nombreProducto }}</td>
                        <td class="p-3">{{ $p->categoria ?? '—' }}</td>
                        <td class="p-3">${{ number_format($p->precio, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded {{ $p->disponibilidad ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $p->disponibilidad ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="p-3">
                            <a href="{{ route('admin.productos.edit', $p) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('admin.productos.destroy', $p) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Eliminar {{ $p->nombreProducto }}?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600 ml-3 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="5">No hay productos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $productos->links() }}
        </div>
    </div>
</x-app-layout>
