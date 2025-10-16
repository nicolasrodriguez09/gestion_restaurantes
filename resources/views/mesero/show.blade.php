@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <a href="{{ route('mesero.dashboard') }}" class="text-sm text-blue-600 hover:underline">&larr; Volver al dashboard</a>

    <h1 class="text-2xl font-semibold mt-3 mb-4">Mesa #{{ $mesa->numeroMesa }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium mb-2">Información</h2>
            <p><strong>Capacidad:</strong> {{ $mesa->capacidad }}</p>
            <p><strong>Estado:</strong> {{ $mesa->estado->nombreEstado ?? 'N/A' }}</p>
            <p class="mt-2 text-sm text-gray-500">Ubicación: {{ $mesa->ubicacion ?? 'No definida' }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium mb-2">Pedidos recientes</h2>

            @if($pedidos->isEmpty())
                <div class="text-sm text-gray-500">No hay pedidos en esta mesa.</div>
            @else
                <ul class="space-y-3">
                    @foreach($pedidos as $pedido)
                        <li class="border p-3 rounded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="font-semibold">Pedido #{{ $pedido->id }}</div>
                                    <div class="text-xs text-gray-500">Estado: {{ $pedido->estado->nombreEstado ?? 'N/A' }}</div>
                                    <div class="text-sm mt-1">
                                        @foreach($pedido->detalles as $det)
                                            <div class="text-sm">• {{ $det->cantidad }} x {{ $det->producto->nombreProducto ?? 'Producto' }}</div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="text-right">
                                    <div class="text-sm text-gray-500">Total</div>
                                    <div class="font-semibold">{{ number_format($pedido->totalPago, 2) }}</div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
