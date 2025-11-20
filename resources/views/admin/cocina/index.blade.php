<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Flujo de cocina</p>
                <h2 class="font-semibold text-2xl text-gray-900">Gestion de preparacion</h2>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-indigo-600 hover:underline">Volver al dashboard</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-6 space-y-6">
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm text-gray-500">En espera</p>
                        <h3 class="text-lg font-semibold text-gray-900">Pendientes de iniciar</h3>
                    </div>
                    <span class="rounded-full bg-amber-100 text-amber-700 px-3 py-1 text-xs font-semibold">{{ $espera->count() }}</span>
                </div>
                <div class="space-y-3 max-h-[70vh] overflow-auto pr-1">
                    @forelse ($espera as $pedido)
                        <div class="rounded-xl border border-slate-100 p-3 bg-amber-50/40">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-gray-900">Pedido #{{ $pedido->id }}</p>
                                <p class="text-xs text-gray-500">Mesa {{ $pedido->mesa->numeroMesa ?? 'N/D' }}</p>
                            </div>
                            <p class="text-xs text-gray-500">Estado: {{ $pedido->estado->nombreEstado ?? 'N/D' }}</p>
                            <ul class="mt-2 space-y-1 text-sm text-gray-800">
                                @foreach($pedido->detalles as $det)
                                    <li class="flex items-center gap-2">
                                        @if($det->producto?->imagen)
                                            <img src="{{ asset('storage/'.$det->producto->imagen) }}" alt="{{ $det->producto->nombreProducto }}" class="h-10 w-10 rounded object-cover border">
                                        @endif
                                        <span>{{ $det->cantidad }} x {{ $det->producto->nombreProducto ?? 'Producto' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            @php $estadoProcesoDefault = $catProceso->first(); @endphp
                            <form action="{{ route('admin.cocina.pedidos.estado', $pedido) }}" method="POST" class="mt-3">
                                @csrf
                                @if($estadoProcesoDefault)
                                    <input type="hidden" name="estado_id" value="{{ $estadoProcesoDefault->id }}">
                                    <button class="w-full rounded bg-indigo-600 text-white text-sm font-semibold py-1.5 hover:bg-indigo-700">Mover a proceso</button>
                                @else
                                    <button class="w-full rounded bg-slate-200 text-slate-500 text-sm font-semibold py-1.5" disabled>Sin estado destino</button>
                                @endif
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Sin pedidos en espera.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm text-gray-500">En proceso</p>
                        <h3 class="text-lg font-semibold text-gray-900">Preparandose</h3>
                    </div>
                    <span class="rounded-full bg-indigo-100 text-indigo-700 px-3 py-1 text-xs font-semibold">{{ $proceso->count() }}</span>
                </div>
                <div class="space-y-3 max-h-[70vh] overflow-auto pr-1">
                    @forelse ($proceso as $pedido)
                        <div class="rounded-xl border border-slate-100 p-3 bg-indigo-50/40">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-gray-900">Pedido #{{ $pedido->id }}</p>
                                <p class="text-xs text-gray-500">Mesa {{ $pedido->mesa->numeroMesa ?? 'N/D' }}</p>
                            </div>
                            <p class="text-xs text-gray-500">Estado: {{ $pedido->estado->nombreEstado ?? 'N/D' }}</p>
                            <ul class="mt-2 space-y-1 text-sm text-gray-800">
                                @foreach($pedido->detalles as $det)
                                    <li class="flex items-center gap-2">
                                        @if($det->producto?->imagen)
                                            <img src="{{ asset('storage/'.$det->producto->imagen) }}" alt="{{ $det->producto->nombreProducto }}" class="h-10 w-10 rounded object-cover border">
                                        @endif
                                        <span>{{ $det->cantidad }} x {{ $det->producto->nombreProducto ?? 'Producto' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            @php $estadoListoDefault = $catListo->first(); @endphp
                            <form action="{{ route('admin.cocina.pedidos.estado', $pedido) }}" method="POST" class="mt-3">
                                @csrf
                                @if($estadoListoDefault)
                                    <input type="hidden" name="estado_id" value="{{ $estadoListoDefault->id }}">
                                    <button class="w-full rounded bg-emerald-600 text-white text-sm font-semibold py-1.5 hover:bg-emerald-700">Mover a listo</button>
                                @else
                                    <button class="w-full rounded bg-slate-200 text-slate-500 text-sm font-semibold py-1.5" disabled>Sin estado destino</button>
                                @endif
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Sin pedidos en proceso.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm text-gray-500">Listos</p>
                        <h3 class="text-lg font-semibold text-gray-900">Para entregar</h3>
                    </div>
                    <span class="rounded-full bg-emerald-100 text-emerald-700 px-3 py-1 text-xs font-semibold">{{ $listo->count() }}</span>
                </div>
                <div class="space-y-3 max-h-[70vh] overflow-auto pr-1">
                    @forelse ($listo as $pedido)
                        <div class="rounded-xl border border-slate-100 p-3 bg-emerald-50/40">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-gray-900">Pedido #{{ $pedido->id }}</p>
                                <p class="text-xs text-gray-500">Mesa {{ $pedido->mesa->numeroMesa ?? 'N/D' }}</p>
                            </div>
                            <p class="text-xs text-gray-500">Estado: {{ $pedido->estado->nombreEstado ?? 'N/D' }}</p>
                            <ul class="mt-2 space-y-1 text-sm text-gray-800">
                                @foreach($pedido->detalles as $det)
                                    <li class="flex items-center gap-2">
                                        @if($det->producto?->imagen)
                                            <img src="{{ asset('storage/'.$det->producto->imagen) }}" alt="{{ $det->producto->nombreProducto }}" class="h-10 w-10 rounded object-cover border">
                                        @endif
                                        <span>{{ $det->cantidad }} x {{ $det->producto->nombreProducto ?? 'Producto' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            @php $estadoProcesoDefault = $catProceso->first(); @endphp
                            <form action="{{ route('admin.cocina.pedidos.estado', $pedido) }}" method="POST" class="mt-3">
                                @csrf
                                @if($estadoProcesoDefault)
                                    <input type="hidden" name="estado_id" value="{{ $estadoProcesoDefault->id }}">
                                    <button class="w-full rounded bg-slate-800 text-white text-sm font-semibold py-1.5 hover:bg-slate-900">Revertir a proceso</button>
                                @else
                                    <button class="w-full rounded bg-slate-200 text-slate-500 text-sm font-semibold py-1.5" disabled>Sin estado destino</button>
                                @endif
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Sin pedidos listos.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
