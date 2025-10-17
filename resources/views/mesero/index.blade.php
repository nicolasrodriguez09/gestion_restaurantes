<x-app-layout>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Panel Mesero</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Tarjeta: Mesas -->
        <div class="col-span-2 bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium mb-3">Mesas</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($mesas as $mesa)
                <a href="{{ route('mesero.mesa.show', $mesa->id) }}" class="block p-3 border rounded hover:shadow">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-500">Mesa</div>
                            <div class="text-xl font-bold">#{{ $mesa->numeroMesa }}</div>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-gray-500">Capacidad</div>
                            <div class="font-medium">{{ $mesa->capacidad }}</div>
                        </div>
                    </div>

                    <div class="mt-2 flex justify-between items-center">
                        <div class="text-xs">
                            Estado:
                            <span class="ml-1 font-semibold">
                                {{ $mesa->estado->nombreEstado ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="text-xs text-gray-500">
                            Pedidos: {{ $mesa->pedidos->count() }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Panel de Pedidos pendientes -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium mb-3">Pedidos en cocina (En espera)</h2>

            @if($pedidosPendientes->isEmpty())
                <div class="text-sm text-gray-500">No hay pedidos pendientes.</div>
            @else
                <ul class="space-y-3">
                    @foreach($pedidosPendientes as $pedido)
                        <li class="border p-3 rounded">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-sm text-gray-500">Mesa #{{ $pedido->id_mesa }}</div>
                                    <div class="font-semibold">Pedido #{{ $pedido->id }}</div>
                                    <div class="text-xs text-gray-500">Solicitado: {{ $pedido->fechaPedido }}</div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('mesero.mesa.show', $pedido->id_mesa) }}" class="inline-block px-3 py-1 bg-blue-600 text-white rounded">Ver mesa</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
