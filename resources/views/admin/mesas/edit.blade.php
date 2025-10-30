<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar mesa #{{ $mesa->numeroMesa }}</h2>
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

        <form action="{{ route('admin.mesas.update', $mesa) }}" method="POST" class="bg-white shadow rounded p-6 space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium">Número de mesa</label>
                <input type="number" name="numeroMesa" value="{{ old('numeroMesa', $mesa->numeroMesa) }}" class="mt-1 w-full border rounded px-3 py-2" required min="1">
            </div>

            <div>
                <label class="block text-sm font-medium">Capacidad</label>
                <input type="number" name="capacidad" value="{{ old('capacidad', $mesa->capacidad) }}" class="mt-1 w-full border rounded px-3 py-2" required min="1" max="50">
            </div>

            <div>
                <label class="block text-sm font-medium">Ubicación</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion', $mesa->ubicacion) }}" class="mt-1 w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Estado</label>
                <select name="id_estado" class="mt-1 w-full border rounded px-3 py-2" required>
                    @foreach ($estados as $id => $nombre)
                        <option value="{{ $id }}" @selected(old('id_estado', $mesa->id_estado) == $id)>{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.mesas.index') }}" class="px-4 py-2 rounded border">Cancelar</a>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
