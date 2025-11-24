<x-app-layout>
<div class="max-w-7xl mx-auto px-6 py-10 space-y-6">
    @php
        $totalMesas = $mesas->count();
        $ocupadas = $mesas->filter(fn($m) => str_contains(strtolower($m->estado->nombreEstado ?? ''), 'ocup'))->count();
        $libres = $totalMesas - $ocupadas;
        $pendientes = $pedidosPendientes->count();
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Operacion en sala</p>
            <h1 class="text-3xl font-bold text-slate-900">Panel de mesero</h1>
            <p class="text-sm text-slate-500">Estado y pedidos de mesas a la vista.</p>
        </div>
        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-100">
            Turno activo
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs text-slate-500">Mesas</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalMesas }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs text-slate-500">Ocupadas</p>
            <p class="text-2xl font-bold text-rose-600">{{ $ocupadas }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs text-slate-500">Libres</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $libres }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs text-slate-500">Pedidos en cocina</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $pendientes }}</p>
        </div>
    </div>

    @php
        $progress = function($pedido) {
            $nombre = strtolower($pedido->estado->nombreEstado ?? '');
            return str_contains($nombre, 'listo') || str_contains($nombre, 'entreg') || str_contains($nombre, 'final') ? 100
                : (str_contains($nombre, 'proc') || str_contains($nombre, 'curso') || str_contains($nombre, 'prep') ? 50 : 0);
        };
    @endphp

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-4">
            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-900">Mesas</h2>
                    <span class="text-xs rounded-full bg-slate-100 px-3 py-1 text-slate-600">Total: {{ $mesas->count() }}</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($mesas as $mesa)
                        @php
                            $estado = strtolower($mesa->estado->nombreEstado ?? 'libre');
                            $color = str_contains($estado, 'ocup') ? 'border-rose-200 bg-rose-50' : 'border-emerald-200 bg-emerald-50';
                            $ultimoPedido = $mesa->pedidos->first();
                            $porc = $ultimoPedido ? $progress($ultimoPedido) : 0;
                        @endphp

                        <div class="block rounded-2xl border {{ $color }} p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-500">Mesa</p>
                                    <p class="text-2xl font-bold text-slate-900">#{{ $mesa->numeroMesa }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-500">Capacidad</p>
                                    <p class="font-semibold text-slate-900">{{ $mesa->capacidad }}</p>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-sm">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 bg-white/70 text-slate-700">
                                    <span class="h-2 w-2 rounded-full {{ str_contains($estado, 'ocup') ? 'bg-rose-500' : 'bg-emerald-500' }}"></span>
                                    {{ ucfirst($estado) }}
                                </span>
                                <span class="text-xs text-slate-500">Pedidos: {{ $mesa->pedidos->count() }}</span>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-xs text-slate-600">
                                <span>Marcar</span>
                                <form action="{{ route('mesero.mesa.estado', $mesa->id) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    @php $esLibre = !str_contains($estado, 'ocup'); @endphp
                                    <input type="hidden" name="estado" value="{{ $esLibre ? 'ocupada' : 'libre' }}">
                                    <button type="submit" class="relative inline-flex h-6 w-12 items-center rounded-full transition {{ $esLibre ? 'bg-slate-200' : 'bg-emerald-500' }}">
                                        <span class="absolute left-1 text-[10px] font-semibold text-white" style="opacity: {{ $esLibre ? '0.5' : '1' }}">O</span>
                                        <span class="absolute right-1 text-[10px] font-semibold text-slate-700" style="opacity: {{ $esLibre ? '1' : '0.5' }}">L</span>
                                        <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition {{ $esLibre ? 'translate-x-0' : 'translate-x-6' }}"></span>
                                    </button>
                                </form>
                            </div>
                            <div class="mt-2">
                                <div class="flex justify-between text-xs text-slate-500">
                                    <span>Avance pedido</span>
                                    <span>{{ $porc }}%</span>
                                </div>
                                <div class="mt-1 h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full rounded-full {{ $porc === 100 ? 'bg-emerald-500' : ($porc === 50 ? 'bg-amber-500' : 'bg-slate-300') }}" style="width: {{ $porc }}%"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('mesero.mesa.show', $mesa->id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-700 hover:text-indigo-900">Ver mesa →</a>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-5 space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Pedidos en cocina</h2>
                    <p class="text-xs text-slate-500">Pedidos esperando pase.</p>
                </div>
                <span class="text-xs rounded-full bg-slate-100 px-3 py-1 text-slate-600">{{ $pedidosPendientes->count() }}</span>
            </div>

            @if($pedidosPendientes->isEmpty())
                <div class="text-sm text-slate-500">No hay pedidos pendientes.</div>
            @else
                <ul class="space-y-3">
                    @foreach($pedidosPendientes as $pedido)
                        <li class="rounded-2xl border border-slate-100 bg-slate-50 p-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-xs text-slate-500">Mesa #{{ $pedido->id_mesa }}</div>
                                    <div class="font-semibold text-slate-900">Pedido #{{ $pedido->id }}</div>
                                    <div class="text-xs text-slate-500">Solicitado: {{ $pedido->fechaPedido }}</div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('mesero.mesa.show', $pedido->id_mesa) }}" class="inline-block rounded-full bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-700">Ver mesa</a>
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
