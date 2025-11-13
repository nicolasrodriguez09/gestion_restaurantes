<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-sm text-gray-500">Control de sala</p>
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">Mesas y ubicaciones</h2>
        </div>
    </x-slot>

    @php
        $totalMesas = method_exists($mesas, 'total') ? $mesas->total() : $mesas->count();
        $porPagina = method_exists($mesas, 'perPage') ? $mesas->perPage() : $mesas->count();
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
                <p class="text-sm text-gray-500">Total registradas</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalMesas }}</p>
                <p class="text-xs text-gray-400 mt-1">Incluye todas las ubicaciones</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">En esta página</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $mesas->count() }}</p>
                <p class="text-xs text-gray-400 mt-1">Mostrando {{ $porPagina }} registros por página</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Búsqueda activa</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">
                    {{ request('buscar') ? '“'.request('buscar').'”' : 'Sin filtros' }}
                </p>
                <p class="text-xs text-gray-400 mt-1">Filtra por número o ubicación</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <form method="GET" action="{{ route('admin.mesas.index') }}" class="flex w-full flex-col gap-3 md:flex-row">
                    <div class="flex-1">
                        <label for="buscar" class="text-sm font-medium text-gray-600 mb-1 block">Buscar</label>
                        <div class="flex rounded-2xl border border-slate-200 bg-white focus-within:border-indigo-400">
                            <input id="buscar" name="buscar" value="{{ request('buscar') }}"
                                   class="w-full rounded-2xl border-none px-4 py-2 text-sm focus:ring-0"
                                   placeholder="Número, ubicación o nota">
                            <button class="mr-1 my-1 rounded-2xl bg-indigo-600 px-4 text-sm font-semibold text-white hover:bg-indigo-700">
                                Aplicar
                            </button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('admin.mesas.create') }}"
                   class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    + Nueva mesa
                </a>
            </div>

            <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-100">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">Mesa</th>
                            <th class="px-4 py-3">Capacidad</th>
                            <th class="px-4 py-3">Ubicación</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($mesas as $mesa)
                            @php
                                $estadoNombre = $mesa->estado?->nombreEstado ?? 'Sin estado';
                                $estadoClase = match (strtolower($estadoNombre)) {
                                    'disponible' => 'bg-emerald-100 text-emerald-700',
                                    'ocupada' => 'bg-rose-100 text-rose-700',
                                    'reservada' => 'bg-amber-100 text-amber-700',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-base font-semibold text-slate-700">
                                            {{ $mesa->numeroMesa }}
                                        </span>
                                        <div>
                                            <p class="font-semibold text-gray-900">Mesa {{ $mesa->numeroMesa }}</p>
                                            <p class="text-xs text-gray-500">ID #{{ $mesa->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-gray-900">{{ $mesa->capacidad }} pax</p>
                                    <p class="text-xs text-gray-500">Capacidad declarada</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-gray-900">{{ $mesa->ubicacion ?? 'No definida' }}</p>
                                    <p class="text-xs text-gray-500">Zona / salón</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center rounded-2xl px-3 py-1 text-xs font-semibold {{ $estadoClase }}">
                                        {{ $estadoNombre }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-3 text-sm">
                                        <a href="{{ route('admin.mesas.edit', $mesa) }}"
                                           class="inline-flex items-center gap-1 rounded-full border border-slate-200 px-3 py-1 font-semibold text-slate-700 hover:border-indigo-200 hover:text-indigo-700">
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.mesas.destroy', $mesa) }}" method="POST" class="inline-flex"
                                              onsubmit="return confirm('Eliminar mesa {{ $mesa->numeroMesa }}?');">
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
                                    No hay mesas registradas. Crea la primera para comenzar a gestionar la sala.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $mesas->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
