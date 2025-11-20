<x-app-layout>
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <a href="{{ route('mesero.dashboard') }}" class="text-sm text-indigo-600 hover:underline">&larr; Volver al dashboard</a>
            <h1 class="text-3xl font-bold text-slate-900 mt-2">Mesa #{{ $mesa->numeroMesa }}</h1>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('mesero.pedido.nuevo', $mesa->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                Hacer pedido
            </a>
            <form action="{{ route('mesero.pedido.cancelar', $mesa->id) }}" method="POST" onsubmit="return confirm('Cancelar pedido en espera?');">
                @csrf
                <button class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700">
                    Cancelar en espera
                </button>
            </form>
            <form action="{{ route('mesero.pedido.cerrar', $mesa->id) }}" method="POST">
                @csrf
                <button class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                    Marcar entregado
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-5">
            <h2 class="text-lg font-semibold text-slate-900 mb-2">Informacion</h2>
            <div class="space-y-2 text-sm text-slate-700">
                <p><strong>Capacidad:</strong> {{ $mesa->capacidad }}</p>
                <p><strong>Estado:</strong> {{ $mesa->estado->nombreEstado ?? 'N/A' }}</p>
                <p class="text-slate-500">Ubicacion: {{ $mesa->ubicacion ?? 'No definida' }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-semibold text-slate-900">Pedidos recientes</h2>
                <span class="text-xs rounded-full bg-slate-100 px-3 py-1 text-slate-600">{{ $pedidos->count() }}</span>
            </div>

            @if($pedidos->isEmpty())
                <div class="text-sm text-slate-500">No hay pedidos en esta mesa.</div>
            @else
                <ul class="space-y-3">
                    @foreach($pedidos as $pedido)
                        @php
                            $estadoLower = strtolower($pedido->estado->nombreEstado ?? '');
                            $esEspera = str_contains($estadoLower, 'espera') || str_contains($estadoLower, 'pend');
                        @endphp
                        <li class="rounded-2xl border border-slate-100 bg-slate-50 p-3">
                            <div class="flex justify-between items-start">
                                <div class="space-y-1">
                                    <div class="font-semibold text-slate-900">Pedido #{{ $pedido->id }}</div>
                                    <div class="text-xs text-slate-500">Estado: {{ $pedido->estado->nombreEstado ?? 'N/A' }}</div>
                                    <div class="text-sm mt-1 space-y-2">
                                        @foreach($pedido->detalles as $det)
                                            <div class="flex items-center gap-2">
                                                @if($det->producto?->imagen)
                                                    <img src="{{ asset('storage/'.$det->producto->imagen) }}" class="h-10 w-10 rounded object-cover">
                                                @endif
                                                <span class="text-slate-800">{{ $det->cantidad }} x {{ $det->producto->nombreProducto ?? 'Producto' }}</span>
                                                @if($esEspera)
                                                    <form action="{{ route('mesero.pedido.detalle.actualizar', [$mesa->id, $det->id]) }}" method="POST" class="flex items-center gap-1 text-xs">
                                                        @csrf
                                                        <input type="number" name="cantidad" value={{ $det->cantidad }} min="1" class="w-16 border rounded px-2 py-1 focus:border-indigo-500 focus:ring-indigo-500">
                                                        <button class="px-2 py-1 bg-slate-800 text-white rounded">Actualizar</button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="text-right">
                                    <div class="text-sm text-slate-500">Total</div>
                                    <div class="font-semibold text-slate-900">{{ number_format($pedido->totalPago, 2) }}</div>
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
