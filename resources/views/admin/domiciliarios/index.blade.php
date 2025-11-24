<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Equipo de entrega</p>
                <h2 class="font-semibold text-2xl text-gray-900">Gestion de domiciliarios</h2>
            </div>
            <a href="{{ route('admin.domiciliarios.create') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                + Nuevo domiciliario
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-6 space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Domiciliario</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Entregas totales</th>
                        <th class="px-4 py-3 text-left">Entregas hoy</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($domiciliarios as $domiciliario)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-900">{{ $domiciliario->name }}</p>
                                <p class="text-xs text-gray-500">ID #{{ $domiciliario->id }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $domiciliario->email }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $domiciliario->entregas_totales ?? 0 }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $domiciliario->entregas_hoy ?? 0 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2 text-sm">
                                    <a href="{{ route('admin.domiciliarios.show', $domiciliario) }}" class="rounded-full border border-slate-200 px-3 py-1 hover:border-indigo-200 hover:text-indigo-700">Ver</a>
                                    <a href="{{ route('admin.domiciliarios.edit', $domiciliario) }}" class="rounded-full border border-slate-200 px-3 py-1 hover:border-indigo-200 hover:text-indigo-700">Editar</a>
                                    <form action="{{ route('admin.domiciliarios.destroy', $domiciliario) }}" method="POST" class="inline-flex" onsubmit="return confirm('Eliminar a {{ $domiciliario->name }}?');">
                                        @csrf @method('DELETE')
                                        <button class="rounded-full border border-transparent px-3 py-1 text-rose-600 hover:bg-rose-50">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">No hay domiciliarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3">
                {{ $domiciliarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
