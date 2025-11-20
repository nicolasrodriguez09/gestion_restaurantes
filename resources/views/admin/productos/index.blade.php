<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-sm text-gray-500">Carta y recetas</p>
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">Productos disponibles</h2>
        </div>
    </x-slot>

    @php
        $totalProductos = $stats['total'] ?? 0;
        $totalDisponibles = $stats['disponibles'] ?? 0; // unidades disponibles globales
        $comidas = $stats['comidas'] ?? ['total' => 0, 'disponibles' => 0];
        $bebidas = $stats['bebidas'] ?? ['total' => 0, 'disponibles' => 0];

        $itemsPagina = method_exists($productos, 'items') ? collect($productos->items()) : collect($productos);
        $disponiblesPagina = $itemsPagina->sum('disponibilidad');
    @endphp

    <div class="py-10 max-w-7xl mx-auto px-6 lg:px-8 space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total registrados</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalProductos }}</p>
                <p class="text-xs text-gray-400 mt-1">Platos, bebidas y complementos</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Unidades disponibles (global)</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalDisponibles }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $disponiblesPagina }} unidades en esta pagina · {{ $itemsPagina->count() }} productos listados</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Unidades por tipo</p>
                <div class="mt-2 space-y-1 text-sm text-gray-700">
                    <p class="flex items-center justify-between">
                        <span class="font-semibold">Comidas</span>
                        <span>{{ $comidas['disponibles'] }} / {{ $comidas['total'] }}</span>
                    </p>
                    <p class="flex items-center justify-between">
                        <span class="font-semibold">Bebidas</span>
                        <span>{{ $bebidas['disponibles'] }} / {{ $bebidas['total'] }}</span>
                    </p>
                </div>
                <p class="text-xs text-gray-400 mt-1">Unidades disponibles registradas</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <form method="GET" action="{{ route('admin.productos.index') }}" class="flex w-full flex-col gap-3 md:flex-row">
                    <div class="flex-1">
                        <label for="buscar" class="text-sm font-medium text-gray-600 mb-1 block">Buscar</label>
                        <div class="flex rounded-2xl border border-slate-200 bg-white focus-within:border-indigo-400">
                            <input id="buscar" name="buscar" value="{{ $q }}"
                                   class="w-full rounded-2xl border-none px-4 py-2 text-sm focus:ring-0"
                                   placeholder="Ej. pasta, bebidas frias">
                            <button class="mr-1 my-1 rounded-2xl bg-indigo-600 px-4 text-sm font-semibold text-white hover:bg-indigo-700">
                                Aplicar
                            </button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('admin.productos.create') }}"
                   class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    + Nuevo producto
                </a>
            </div>

            <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-100">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">Producto</th>
                            <th class="px-4 py-3">Imagen</th>
                            <th class="px-4 py-3">Categoria</th>
                            <th class="px-4 py-3">Precio</th>
                            <th class="px-4 py-3">Cantidad</th>
                            <th class="px-4 py-3">Estado</th>
            <th class="px-4 py-3 text-right">Acciones</th>
        </tr>
    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($productos as $producto)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-gray-900">{{ $producto->nombreProducto }}</p>
                                    <p class="text-xs text-gray-500">ID #{{ $producto->id }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($producto->imagen)
                                        <img src="{{ asset('storage/'.$producto->imagen) }}" alt="Imagen {{ $producto->nombreProducto }}" class="h-14 w-14 rounded object-cover border">
                                    @else
                                        <span class="text-xs text-gray-500">Sin imagen</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-gray-900">{{ $producto->categoria ?? 'Sin categoria' }}</p>
                                    <p class="text-xs text-gray-500">Clasificacion</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-gray-900">${{ number_format($producto->precio, 2, '.', ',') }}</p>
                                    <p class="text-xs text-gray-500">Precio venta</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-gray-900">{{ $producto->disponibilidad }}</p>
                                    <p class="text-xs text-gray-500">Unidades</p>
                                </td>
                                <td class="px-4 py-4">
                                    @php
                                        $disponible = (int) $producto->disponibilidad > 0;
                                        $badgeClasses = $disponible
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-rose-100 text-rose-700';
                                    @endphp
                                    <span class="inline-flex items-center rounded-2xl px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                        {{ $disponible ? 'Disponible' : 'Agotado' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-3 text-sm">
                                        <a href="{{ route('admin.productos.edit', $producto) }}"
                                           class="inline-flex items-center gap-1 rounded-full border border-slate-200 px-3 py-1 font-semibold text-slate-700 hover:border-indigo-200 hover:text-indigo-700">
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST" class="inline-flex"
                                              onsubmit="return confirm('Eliminar {{ $producto->nombreProducto }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex items-center gap-1 rounded-full border border-transparent px-3 py-1 font-semibold text-rose-600 hover:bg-rose-50">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                                    No hay productos registrados. Crea el primero para completar la carta.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $productos->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
