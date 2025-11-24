<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm text-gray-500">Pedidos a domicilio</p>
            <h2 class="font-semibold text-2xl text-gray-900">Domicilios</h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-6 space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="p-4 flex items-center justify-between">
                <p class="text-sm text-slate-500">Total: {{ $domicilios->total() }}</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3 text-left">Pedido</th>
                            <th class="px-4 py-3 text-left">Cliente</th>
                            <th class="px-4 py-3 text-left">Direccion</th>
                            <th class="px-4 py-3 text-left">Contacto</th>
                            <th class="px-4 py-3 text-left">Domiciliario</th>
                            <th class="px-4 py-3 text-left">Nota</th>
                            <th class="px-4 py-3 text-left">Estado</th>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($domicilios as $pedido)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 font-semibold text-slate-900">#{{ $pedido->id }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-900">{{ $pedido->cliente_nombre ?? 'N/D' }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $pedido->cliente_direccion ?? 'N/D' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $pedido->cliente_telefono ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $pedido->domiciliario->name ?? 'Sin asignar' }}</td>
                                <td class="px-4 py-3 text-xs text-slate-500">{{ $pedido->cliente_nota ?? '-' }}</td>
                                @php
                                    $estado = strtolower($pedido->estado->nombreEstado ?? '');
                                    $badge = str_contains($estado, 'listo') ? 'bg-emerald-100 text-emerald-700' :
                                             (str_contains($estado, 'espera') ? 'bg-amber-100 text-amber-700' :
                                             (str_contains($estado, 'entreg') ? 'bg-slate-200 text-slate-700' : 'bg-slate-100 text-slate-700'));
                                @endphp
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                                        {{ $pedido->estado->nombreEstado ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-500">{{ \Carbon\Carbon::parse($pedido->fechaPedido)->format('d/m H:i') }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-900">${{ number_format($pedido->totalPago, 2, '.', ',') }}</td>
                            </tr>
                            <tr class="bg-slate-50/60">
                                <td colspan="7" class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2 text-xs text-slate-700">
                                        @foreach($pedido->detalles as $det)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-white border border-slate-200 px-3 py-1">
                                                {{ $det->cantidad }} x {{ $det->producto->nombreProducto ?? 'Producto' }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">No hay pedidos a domicilio.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3">
                {{ $domicilios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
