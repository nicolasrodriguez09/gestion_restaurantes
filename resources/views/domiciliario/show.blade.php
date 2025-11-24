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

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Acciones</h3>
                <form action="{{ route('domiciliario.pedido.entregar', $pedido->id) }}" method="POST" class="mt-3">
                    @csrf
                    <button class="w-full rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        Marcar como entregado
                    </button>
                </form>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900 mb-3">Productos</h3>
            <div class="grid sm:grid-cols-2 gap-3 text-sm text-slate-700">
                @foreach($pedido->detalles as $det)
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 flex items-center justify-between">
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
