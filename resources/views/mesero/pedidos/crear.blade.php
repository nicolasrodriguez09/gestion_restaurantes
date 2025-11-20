<x-app-layout>
<div class="container mx-auto p-4">
    {{-- Titulo y volver --}}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">
            Nuevo pedido - Mesa #{{ $mesa->numeroMesa }}
        </h1>
        <a href="{{ route('mesero.mesa.show', $mesa->id) }}"
           class="text-blue-600 hover:underline">Volver a la mesa</a>
    </div>

    {{-- Mensajes flash --}}
    @if(session('ok'))
        <div class="mb-3 p-3 rounded bg-green-100 text-green-700">
            {{ session('ok') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-3 p-3 rounded bg-red-100 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- (Debug) Muestra la URL a la que se hara POST --}}
    <div class="mb-2 text-xs text-gray-500">
        Accion POST a: <code>{{ route('mesero.pedido.agregar', $mesa->id) }}</code>
    </div>

    {{-- Productos disponibles --}}
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-medium mb-3">Productos disponibles</h2>

        @if($productos->isEmpty())
            <div class="text-sm text-gray-500">No hay productos configurados.</div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($productos as $prod)
                    <div class="border rounded p-3 hover:shadow transition bg-white flex flex-col gap-2">
                        <div class="h-32 w-full overflow-hidden rounded-lg bg-gray-50 flex items-center justify-center">
                            @if ($prod->imagen)
                                <img src="{{ asset('storage/'.$prod->imagen) }}" alt="Imagen {{ $prod->nombreProducto }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-xs text-gray-400">Sin imagen</span>
                            @endif
                        </div>
                        <div>
                            <div class="font-semibold">{{ $prod->nombreProducto }}</div>
                            <div class="text-sm text-gray-500 mb-1">{{ $prod->descripcion }}</div>
                            <div class="text-sm text-gray-700 font-medium mb-1">
                                ${{ number_format($prod->precio, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500">Categoria: {{ $prod->categoria }}</div>
                        </div>

                        {{-- Formulario para agregar (POST forzado) --}}
                        <form method="POST"
                              action="{{ route('mesero.pedido.agregar', $mesa->id) }}"
                              class="flex items-center gap-2 mt-auto">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $prod->id }}">
                            <input type="number" name="cantidad" value="1" min="1"
                                   class="w-16 border rounded px-2 py-1 text-center" required>

                            <button
                                type="submit"
                                formmethod="post"
                                formaction="{{ route('mesero.pedido.agregar', $mesa->id) }}"
                                class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
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
