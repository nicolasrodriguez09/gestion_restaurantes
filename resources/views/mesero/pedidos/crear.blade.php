<x-app-layout>
<div class="max-w-7xl mx-auto px-6 py-8 space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Armar pedido</p>
            <h1 class="text-2xl font-bold text-slate-900">Mesa #{{ $mesa->numeroMesa }}</h1>
        </div>
        <a href="{{ route('mesero.mesa.show', $mesa->id) }}"
           class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-200 hover:text-indigo-700">Volver a la mesa</a>
    </div>

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

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-slate-900">Productos disponibles</h2>
            <span class="text-xs rounded-full bg-slate-100 px-3 py-1 text-slate-600">{{ $productos->count() }}</span>
        </div>

        @if($productos->isEmpty())
            <div class="text-sm text-gray-500">No hay productos configurados.</div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($productos as $prod)
                    <div class="rounded-2xl border border-slate-100 p-3 hover:shadow-md transition bg-white flex flex-col gap-2">
                        <div class="h-32 w-full overflow-hidden rounded-xl bg-slate-50 flex items-center justify-center">
                            @if ($prod->imagen)
                                <img src="{{ asset('storage/'.$prod->imagen) }}" alt="Imagen {{ $prod->nombreProducto }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-xs text-gray-400">Sin imagen</span>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <div class="font-semibold text-slate-900">{{ $prod->nombreProducto }}</div>
                            <div class="text-sm text-slate-500 line-clamp-2">{{ $prod->descripcion }}</div>
                            <div class="text-sm font-semibold text-slate-900">
                                ${{ number_format($prod->precio, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-slate-500">Categoria: {{ $prod->categoria }}</div>
                            <div class="text-xs text-emerald-700">Stock: {{ $prod->disponibilidad }}</div>
                        </div>

                        <form method="POST"
                              action="{{ route('mesero.pedido.agregar', $mesa->id) }}"
                              class="flex items-center gap-2 mt-auto">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $prod->id }}">
                            <input type="number" name="cantidad" value="1" min="1"
                                   class="w-16 border rounded px-2 py-1 text-center focus:border-indigo-500 focus:ring-indigo-500" required>

                            <button
                                type="submit"
                                formmethod="post"
                                formaction="{{ route('mesero.pedido.agregar', $mesa->id) }}"
                                class="px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-sm font-semibold">
                                Agregar
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
</x-app-layout>
