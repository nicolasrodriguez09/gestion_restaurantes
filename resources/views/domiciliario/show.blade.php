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

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Mapa y ruta</h3>
                <span class="text-xs px-3 py-1 rounded-full bg-indigo-50 text-indigo-700">Origen: restaurante</span>
            </div>
            @if(!$pedido->cliente_lat || !$pedido->cliente_lng)
                <p class="text-sm text-slate-600">Este pedido aun no tiene coordenadas guardadas.</p>
            @else
                <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
                <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
                <style>.mapa-pedido{height:320px;border-radius:16px;border:1px solid #e5e7eb;overflow:hidden}</style>
                <div id="mapa-pedido" class="mapa-pedido"></div>
                <p class="text-xs text-slate-500" id="ruta-estado">Calculando ruta con OSRM (OpenStreetMap)...</p>
                @php
                    $gmapsUrl = 'https://www.google.com/maps/dir/?api=1&origin='
                        .config('services.maps.origin_lat').','.config('services.maps.origin_lng')
                        .'&destination='.$pedido->cliente_lat.','.$pedido->cliente_lng.'&travelmode=driving';
                    $osmUrl = 'https://www.openstreetmap.org/directions?engine=fossgis_osrm_car&route='
                        .config('services.maps.origin_lat').'%2C'.config('services.maps.origin_lng')
                        .'%3B'.$pedido->cliente_lat.'%2C'.$pedido->cliente_lng;
                @endphp
                <div class="flex flex-wrap gap-2 text-sm">
                    <a href="{{ $gmapsUrl }}" target="_blank" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-700">Abrir en Google Maps</a>
                    <a href="{{ $osmUrl }}" target="_blank" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 font-semibold text-slate-700 hover:border-indigo-200 hover:text-indigo-700">Abrir en OpenStreetMap</a>
                </div>

                <script>
                    (function() {
                        const destLat = parseFloat(@json($pedido->cliente_lat));
                        const destLng = parseFloat(@json($pedido->cliente_lng));
                        const originLat = parseFloat(@json(config('services.maps.origin_lat')));
                        const originLng = parseFloat(@json(config('services.maps.origin_lng')));
                        const statusEl = document.getElementById('ruta-estado');

                        if (!Number.isFinite(destLat) || !Number.isFinite(destLng)) {
                            if (statusEl) statusEl.textContent = 'No hay coordenadas del cliente.';
                            return;
                        }

                        const map = L.map('mapa-pedido').setView([destLat, destLng], 14);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap'
                        }).addTo(map);

                        const destino = L.marker([destLat, destLng]).addTo(map).bindPopup('Entrega');
                        const origen = L.circleMarker([originLat, originLng], { radius: 8, color: '#4f46e5', fillColor: '#4f46e5', fillOpacity: 0.9 }).addTo(map).bindPopup('Restaurante');

                        const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${originLng},${originLat};${destLng},${destLat}?overview=full&geometries=geojson`;

                        fetch(osrmUrl)
                            .then(r => r.json())
                            .then(data => {
                                if (data.code !== 'Ok' || !data.routes || !data.routes.length) {
                                    throw new Error('Sin ruta');
                                }
                                const route = data.routes[0];
                                const geo = L.geoJSON(route.geometry, { style: { color: '#4f46e5', weight: 5, opacity: 0.85 } }).addTo(map);
                                const group = L.featureGroup([destino, origen, geo]);
                                map.fitBounds(group.getBounds(), { padding: [20, 20] });
                                if (statusEl) statusEl.textContent = 'Ruta calculada con OSRM (trazado en morado).';
                            })
                            .catch(() => {
                                if (statusEl) statusEl.textContent = 'No se pudo calcular la ruta (servicio OSRM). Usa los enlaces de navegacion.';
                                map.fitBounds(L.featureGroup([destino, origen]).getBounds(), { padding: [20, 20] });
                            });
                    })();
                </script>
            @endif
        </div>
    </div>
</x-app-layout>
