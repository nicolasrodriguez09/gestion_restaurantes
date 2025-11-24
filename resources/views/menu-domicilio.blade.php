<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedir domicilio | DigiRest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <style>
        body{font-family:'Inter',sans-serif}
        .mapa-entrega{height:280px;border-radius:16px;border:1px solid #e5e7eb;overflow:hidden;background:linear-gradient(135deg,#eef2ff,#e2e8f0)}
        .autocomplete-list{position:absolute;z-index:20;top:100%;left:0;right:0;max-height:220px;overflow-y:auto;border:1px solid #e5e7eb;background:#fff;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.08)}
        .autocomplete-item{padding:8px 12px;font-size:14px;color:#0f172a;cursor:pointer}
        .autocomplete-item:hover{background:#eef2ff}
    </style>
</head>
<body class="bg-gradient-to-b from-white via-slate-50 to-indigo-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-indigo-100 bg-white/90 backdrop-blur">
            <nav class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 text-xl font-bold text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-white">DR</span>
                    Digi<span class="text-indigo-600">Rest</span>
                </a>
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-200 hover:text-indigo-700">Ver menu</a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Acceder</a>
                </div>
            </nav>
        </header>

        <main class="flex-1">
            <section class="max-w-6xl mx-auto px-6 py-12 space-y-6">
                <div class="rounded-3xl border border-indigo-100 bg-white shadow-xl p-6">
                    <div class="flex items-start justify-between flex-wrap gap-4">
                        <div>
                            <p class="text-xs font-semibold tracking-[0.28em] text-indigo-600 uppercase">Domicilio</p>
                            <h1 class="text-3xl font-bold text-slate-900">Arma tu pedido</h1>
                            <p class="text-sm text-slate-600">Selecciona cantidades y dejanos tu direccion. El pedido va directo a cocina.</p>
                        </div>
                        <div class="flex flex-wrap gap-2 text-sm">
                            <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-indigo-700">Comidas: {{ $comidas->count() }}</span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-sky-50 px-3 py-1 text-sky-700">Bebidas: {{ $bebidas->count() }}</span>
                        </div>
                    </div>
                    @if(session('ok'))
                        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
                            {{ session('ok') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800 text-sm space-y-1">
                            @foreach($errors->all() as $err)
                                <p>{{ $err }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('menu.pedido') }}" class="space-y-8">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm space-y-3">
                            <h3 class="text-lg font-semibold text-slate-900">Datos de entrega</h3>
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <label class="text-sm text-slate-600">Nombre</label>
                                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-600">Telefono</label>
                                    <input type="text" name="telefono" value="{{ old('telefono') }}" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-600">Direccion de entrega</label>
                                    <div class="relative mt-1">
                                        <input type="text" name="direccion" id="direccion-buscar" value="{{ old('direccion') }}" placeholder="Escribe tu direccion y selecciona en el listado" class="w-full rounded-xl border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="off" required>
                                        <div id="autocomplete-results" class="hidden autocomplete-list"></div>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">Busca la direccion y luego confirma en el mapa (requerido).</p>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-600">Nota</label>
                                    <textarea name="nota" rows="2" class="mt-1 w-full rounded-xl border px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('nota') }}</textarea>
                                </div>
                                <input type="hidden" name="cliente_lat" id="cliente_lat" value="{{ old('cliente_lat') }}">
                                <input type="hidden" name="cliente_lng" id="cliente_lng" value="{{ old('cliente_lng') }}">
                                <input type="hidden" name="cliente_place_id" id="cliente_place_id" value="{{ old('cliente_place_id') }}">
                            </div>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-semibold text-slate-900">Confirma en el mapa</p>
                                    <span class="text-xs text-slate-500">Click o arrastra el pin</span>
                                </div>
                                <div id="mapa-entrega" class="mapa-entrega"></div>
                                <p class="text-xs text-slate-500">Tambien puedes hacer click en el mapa para fijar el punto exacto.</p>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-900">Resumen</h3>
                            <p class="text-sm text-slate-500">Selecciona cantidades y verifica tu pedido antes de enviar.</p>
                            <div class="mt-3 rounded-xl border border-indigo-100 bg-indigo-50 p-3 text-sm text-slate-800 space-y-2" id="resumen-lista">
                                <p class="text-xs font-semibold text-indigo-700 uppercase tracking-[0.2em]">Tu pedido</p>
                                <div class="space-y-1" id="resumen-items">
                                    <p class="text-xs text-slate-500">Sin items aun.</p>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-indigo-100">
                                    <span class="text-xs text-slate-500">Estimado</span>
                                    <span class="font-semibold text-slate-900" id="resumen-total">$0</span>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-700 transition">Enviar pedido a domicilio</button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-3xl border border-indigo-100 bg-white shadow-sm p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-slate-900">Comidas</h2>
                                <span class="text-xs rounded-full bg-indigo-100 px-3 py-1 text-indigo-700">{{ $comidas->count() }}</span>
                            </div>
                            @if($comidas->isEmpty())
                                <div class="text-sm text-gray-500">No hay comidas configuradas.</div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($comidas as $prod)
                                        <div class="rounded-2xl border border-indigo-100 p-3 hover:shadow-lg transition bg-white flex flex-col gap-2">
                                            <div class="h-36 w-full overflow-hidden rounded-xl bg-indigo-50 flex items-center justify-center">
                                                @if ($prod->imagen)
                                                    <img src="{{ asset('storage/'.$prod->imagen) }}" alt="Imagen {{ $prod->nombreProducto }}" class="h-full w-full object-cover">
                                                @else
                                                    <span class="text-xs text-gray-400">Sin imagen</span>
                                                @endif
                                            </div>
                                            <div class="space-y-1">
                                                <div class="font-semibold text-slate-900">{{ $prod->nombreProducto }}</div>
                                                <div class="text-sm text-slate-500 line-clamp-2">{{ $prod->descripcion }}</div>
                                                <div class="text-sm font-bold text-indigo-600">${{ number_format($prod->precio, 0, ',', '.') }}</div>
                                                <div class="text-xs text-emerald-700">Stock: {{ $prod->disponibilidad }}</div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-auto">
                                                <input type="number" name="cantidad[{{ $prod->id }}]" value="{{ old('cantidad.'.$prod->id, 0) }}" min="0"
                                                       data-nombre="{{ $prod->nombreProducto }}" data-precio="{{ $prod->precio }}"
                                                       class="cantidad-input w-16 border rounded px-2 py-1 text-center focus:border-indigo-500 focus:ring-indigo-500">
                                                <span class="text-xs text-slate-500">Unidades</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="rounded-3xl border border-indigo-100 bg-white shadow-sm p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-slate-900">Bebidas</h2>
                                <span class="text-xs rounded-full bg-indigo-100 px-3 py-1 text-indigo-700">{{ $bebidas->count() }}</span>
                            </div>
                            @if($bebidas->isEmpty())
                                <div class="text-sm text-gray-500">No hay bebidas configuradas.</div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($bebidas as $prod)
                                        <div class="rounded-2xl border border-indigo-100 p-3 hover:shadow-lg transition bg-white flex flex-col gap-2">
                                            <div class="h-36 w-full overflow-hidden rounded-xl bg-indigo-50 flex items-center justify-center">
                                                @if ($prod->imagen)
                                                    <img src="{{ asset('storage/'.$prod->imagen) }}" alt="Imagen {{ $prod->nombreProducto }}" class="h-full w-full object-cover">
                                                @else
                                                    <span class="text-xs text-gray-400">Sin imagen</span>
                                                @endif
                                            </div>
                                            <div class="space-y-1">
                                                <div class="font-semibold text-slate-900">{{ $prod->nombreProducto }}</div>
                                                <div class="text-sm text-slate-500 line-clamp-2">{{ $prod->descripcion }}</div>
                                                <div class="text-sm font-bold text-indigo-600">${{ number_format($prod->precio, 0, ',', '.') }}</div>
                                                <div class="text-xs text-emerald-700">Stock: {{ $prod->disponibilidad }}</div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-auto">
                                                <input type="number" name="cantidad[{{ $prod->id }}]" value="{{ old('cantidad.'.$prod->id, 0) }}" min="0"
                                                       data-nombre="{{ $prod->nombreProducto }}" data-precio="{{ $prod->precio }}"
                                                       class="cantidad-input w-16 border rounded px-2 py-1 text-center focus:border-indigo-500 focus:ring-indigo-500">
                                                <span class="text-xs text-slate-500">Unidades</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>
    <script>
        (function() {
            const originLat = Number(@json($originLat));
            const originLng = Number(@json($originLng));

            const direccionInput = document.getElementById('direccion-buscar');
            const resultsBox = document.getElementById('autocomplete-results');
            const latInput = document.getElementById('cliente_lat');
            const lngInput = document.getElementById('cliente_lng');
            const placeInput = document.getElementById('cliente_place_id');
            const mapaEl = document.getElementById('mapa-entrega');
            const initialLat = parseFloat(@json(old('cliente_lat')));
            const initialLng = parseFloat(@json(old('cliente_lng')));

            let map = null;
            let marker = null;
            let searchTimer = null;

            function setLocation(lat, lng, label = null, placeId = null) {
                if (!latInput || !lngInput) return;
                latInput.value = lat;
                lngInput.value = lng;
                if (placeInput) placeInput.value = placeId || '';
                if (label && direccionInput) direccionInput.value = label;

                if (map) {
                    if (!marker) {
                        marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                        marker.on('dragend', function(e) {
                            const pos = e.target.getLatLng();
                            latInput.value = pos.lat.toFixed(6);
                            lngInput.value = pos.lng.toFixed(6);
                        });
                    } else {
                        marker.setLatLng([lat, lng]);
                    }
                    map.setView([lat, lng], 16);
                }

                if (resultsBox) {
                    resultsBox.classList.add('hidden');
                    resultsBox.innerHTML = '';
                }
            }

            function renderResults(items) {
                if (!resultsBox) return;
                if (!items.length) {
                    resultsBox.classList.add('hidden');
                    resultsBox.innerHTML = '';
                    return;
                }
                resultsBox.innerHTML = items.map(item => {
                    const name = item.display_name || 'Direccion';
                    return `<div class="autocomplete-item" data-lat="${item.lat}" data-lng="${item.lon}" data-place="${item.place_id}">${name}</div>`;
                }).join('');
                resultsBox.classList.remove('hidden');

                resultsBox.querySelectorAll('.autocomplete-item').forEach(el => {
                    el.addEventListener('click', () => {
                        const lat = parseFloat(el.dataset.lat);
                        const lng = parseFloat(el.dataset.lng);
                        const place = el.dataset.place || '';
                        setLocation(lat, lng, el.textContent.trim(), place);
                    });
                });
            }

            function buscarDireccion(q) {
                // Delimita busquedas al norte del Valle del Cauca, Colombia
                const url = 'https://nominatim.openstreetmap.org/search'
                    + '?format=jsonv2&limit=5&accept-language=es'
                    + '&countrycodes=co&bounded=1&viewbox=-76.9,5.2,-75.7,4.0'
                    + '&q=' + encodeURIComponent(q);
                fetch(url, { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(data => renderResults(data || []))
                    .catch(() => renderResults([]));
            }

            if (mapaEl) {
                if (typeof L === 'undefined') {
                    mapaEl.innerHTML = '<div class="h-full w-full flex items-center justify-center text-sm text-slate-600 px-3 text-center">No se pudo cargar el mapa. Verifica tu conexion.</div>';
                } else {
                    const hasInitial = Number.isFinite(initialLat) && Number.isFinite(initialLng);
                    const startLat = hasInitial ? initialLat : originLat;
                    const startLng = hasInitial ? initialLng : originLng;

                    map = L.map('mapa-entrega').setView([startLat, startLng], 14);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(map);

                    if (hasInitial) {
                        setLocation(initialLat, initialLng, direccionInput?.value || null, placeInput?.value || null);
                    }

                    map.on('click', function(e) {
                        setLocation(e.latlng.lat, e.latlng.lng, direccionInput?.value || 'Punto seleccionado', null);
                    });
                }
            }

            if (direccionInput) {
                direccionInput.addEventListener('input', function() {
                    const q = this.value.trim();
                    if (searchTimer) clearTimeout(searchTimer);
                    if (q.length < 3) {
                        renderResults([]);
                        return;
                    }
                    searchTimer = setTimeout(() => buscarDireccion(q), 350);
                });
            }

            const inputs = document.querySelectorAll('.cantidad-input');
            const lista = document.getElementById('resumen-items');
            const totalEl = document.getElementById('resumen-total');

            function actualizarResumen() {
                const seleccion = [];
                let total = 0;
                inputs.forEach(inp => {
                    const qty = parseInt(inp.value, 10) || 0;
                    if (qty > 0) {
                        const nombre = inp.dataset.nombre || 'Producto';
                        const precio = parseFloat(inp.dataset.precio || 0);
                        const subtotal = precio * qty;
                        total += subtotal;
                        seleccion.push({ nombre, qty, subtotal });
                    }
                });

                if (!lista) return;
                if (seleccion.length === 0) {
                    lista.innerHTML = '<p class="text-xs text-slate-500">Sin items aun.</p>';
                } else {
                    lista.innerHTML = seleccion.map(item =>
                        `<div class="flex items-center justify-between text-sm">
                            <span>${item.qty} x ${item.nombre}</span>
                            <span class="font-semibold">$${item.subtotal.toLocaleString('es-CO', {minimumFractionDigits:0})}</span>
                        </div>`
                    ).join('');
                }
                if (totalEl) {
                    totalEl.textContent = '$' + total.toLocaleString('es-CO', {minimumFractionDigits:0});
                }
            }

            inputs.forEach(inp => {
                inp.addEventListener('input', actualizarResumen);
            });
            actualizarResumen();
        })();
    </script>
</body>
</html>
