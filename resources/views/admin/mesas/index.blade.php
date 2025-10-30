<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Mesas</h2>
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
            <form method="GET" action="{{ route('admin.mesas.index') }}" class="flex gap-2">
                <input name="buscar" value="{{ request('buscar') }}" class="border rounded px-2 py-1"
                       placeholder="Buscar por número o ubicación...">
                <button class="bg-gray-800 text-white px-3 py-1 rounded">Buscar</button>
            </form>

            <a href="{{ route('admin.mesas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Nueva mesa
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-3">#</th>
                        <th class="text-left p-3">Capacidad</th>
                        <th class="text-left p-3">Ubicación</th>
                        <th class="text-left p-3">Estado</th>
                        <th class="text-left p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($mesas as $mesa)
                    <tr class="border-t">
                        <td class="p-3">{{ $mesa->numeroMesa }}</td>
                        <td class="p-3">{{ $mesa->capacidad }}</td>
                        <td class="p-3">{{ $mesa->ubicacion }}</td>
                        <td class="p-3">{{ $mesa->estado?->nombreEstado ?? '—' }}</td>

                        <td class="p-3">
                            <a href="{{ route('admin.mesas.edit', $mesa) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('admin.mesas.destroy', $mesa) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Eliminar mesa {{ $mesa->numeroMesa }}?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600 ml-3 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="5">No hay mesas registradas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $mesas->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
