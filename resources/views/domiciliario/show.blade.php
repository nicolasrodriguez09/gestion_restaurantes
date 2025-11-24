<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm text-gray-500">Pedido a domicilio</p>
            <h2 class="font-semibold text-2xl text-gray-900">Pedido #{{ $pedido->id }}</h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-6 space-y-6">
        @if(session('ok'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
                {{ session('ok') }}
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm space-y-2">
                <h3 class="text-lg font-semibold text-slate-900">Datos del cliente</h3>
                <p class="text-sm text-slate-700"><strong>Nombre:</strong> {{ $pedido->cliente_nombre ?? 'N/D' }}</p>
                <p class="text-sm text-slate-700"><strong>Telefono:</strong> {{ $pedido->cliente_telefono ?? 'N/D' }}</p>
                <p class="text-sm text-slate-700"><strong>Direccion:</strong> {{ $pedido->cliente_direccion ?? 'N/D' }}</p>
                <p class="text-sm text-slate-700"><strong>Nota:</strong> {{ $pedido->cliente_nota ?? '-' }}</p>
                <p class="text-sm text-slate-700"><strong>Estado:</strong> {{ $pedido->estado->nombreEstado ?? 'N/A' }}</p>
                <p class="text-sm text-slate-700"><strong>Hora:</strong> {{ \Carbon\Carbon::parse($pedido->fechaPedido)->format('d/m H:i') }}</p>
            </div>

            @php
                $estado = strtolower($pedido->estado->nombreEstado ?? '');
                $ready = str_contains($estado, 'listo');
                $entregado = str_contains($estado, 'entreg');
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-900 via-indigo-900 to-indigo-700 p-5 shadow-sm text-white space-y-3">
                <h3 class="text-lg font-semibold">Acciones</h3>
                <p class="text-sm opacity-80">Marca el pedido como entregado solo cuando este listo.</p>
                <form action="{{ route('domiciliario.pedido.entregar', $pedido->id) }}" method="POST" class="space-y-2">
                    @csrf
                    <button {{ !$ready || $entregado ? 'disabled' : '' }} class="w-full rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 bg-emerald-200 hover:bg-emerald-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        Marcar como entregado
                    </button>
                </form>
                @if(!$ready && !$entregado)
                    <div class="rounded-lg bg-white/10 px-3 py-2 text-sm">Aun no esta listo para entregar.</div>
                @elseif($entregado)
                    <div class="rounded-lg bg-white/10 px-3 py-2 text-sm">Pedido ya entregado.</div>
                @endif
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900 mb-3">Productos</h3>
            <div class="grid sm:grid-cols-2 gap-3 text-sm text-slate-700">
                @foreach($pedido->detalles as $det)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-3 flex items-center justify-between">
                        <div>
                            <p class="font-semibold">{{ $det->producto->nombreProducto ?? 'Producto' }}</p>
                            <p class="text-xs text-slate-500">{{ $det->cantidad }} x ${{ number_format($det->precioUnitario, 2, '.', ',') }}</p>
                        </div>
                        <p class="font-semibold text-slate-900">${{ number_format($det->subTotal, 2, '.', ',') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
