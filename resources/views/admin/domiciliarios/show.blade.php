<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm text-gray-500">Detalle de domiciliario</p>
            <h2 class="font-semibold text-2xl text-gray-900">{{ $domiciliario->name }}</h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-gray-500">Entregas hoy</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $entregasHoy }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-gray-500">Entregas registradas</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalEntregas }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-gray-500">Email</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $domiciliario->email }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ultimas entregas</h3>
            @forelse ($entregas as $pedido)
                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 mb-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Pedido #{{ $pedido->id }}</p>
                            <p class="text-xs text-slate-500">Cliente: {{ $pedido->cliente_nombre ?? 'N/D' }}</p>
                            <p class="text-xs text-slate-500">Direccion: {{ $pedido->cliente_direccion ?? 'N/D' }}</p>
                            <p class="text-xs text-slate-500">Fecha: {{ \Carbon\Carbon::parse($pedido->fechaPedido)->format('d/m H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500">Total</p>
                            <p class="text-lg font-semibold text-slate-900">${{ number_format($pedido->totalPago, 2, '.', ',') }}</p>
                            <p class="text-xs text-slate-500">{{ $pedido->estado->nombreEstado ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-3 border-t border-slate-100 pt-3">
                        <p class="text-xs font-semibold text-slate-600 mb-2">Productos</p>
                        <ul class="space-y-2">
                            @foreach($pedido->detalles as $det)
                                <li class="flex items-center gap-3 text-sm text-slate-800">
                                    @if($det->producto?->imagen)
                                        <img src="{{ asset('storage/'.$det->producto->imagen) }}" class="h-10 w-10 rounded object-cover">
                                    @endif
                                    <span>{{ $det->cantidad }} x {{ $det->producto->nombreProducto ?? 'Producto' }}</span>
                                    <span class="text-xs text-slate-500">${{ number_format($det->subTotal, 2, '.', ',') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <div class="text-sm text-gray-500">No hay entregas registradas.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
