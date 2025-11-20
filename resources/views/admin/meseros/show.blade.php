<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm text-gray-500">Detalle de mesero</p>
            <h2 class="font-semibold text-2xl text-gray-900">{{ $mesero->name }}</h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-gray-500">Pedidos hoy</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPedidosHoy }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-gray-500">Mesas atendidas hoy</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalMesasHoy }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-gray-500">Email</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $mesero->email }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pedidos de hoy</h3>
            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3 text-left">Pedido</th>
                            <th class="px-4 py-3 text-left">Mesa</th>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pedidosHoy as $pedido)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">#{{ $pedido->id }}</td>
                                <td class="px-4 py-3">{{ $pedido->mesa->numeroMesa ?? 'N/D' }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pedido->fechaPedido)->format('d/m H:i') }}</td>
                                <td class="px-4 py-3">${{ number_format($pedido->totalPago, 2, '.', ',') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">No hay pedidos hoy.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
