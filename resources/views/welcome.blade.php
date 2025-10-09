<body class="font-sans antialiased bg-amber-50 text-zinc-900">
    <!-- Navbar -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md shadow-md z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-amber-800">Café Aroma</h1>
            <ul class="hidden md:flex space-x-8 font-medium text-amber-900">
                <li><a href="#" class="hover:text-amber-700">Inicio</a></li>
                <li><a href="#productos" class="hover:text-amber-700">Productos</a></li>
                <li><a href="#nosotros" class="hover:text-amber-700">Nosotros</a></li>
                <li><a href="#contacto" class="hover:text-amber-700">Contacto</a></li>
            </ul>
            <a href="#" class="bg-amber-800 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition">
                Comprar ahora
            </a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="relative h-[90vh] flex items-center justify-center text-center text-white bg-cover bg-center" 
        style="background-image: url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10">
            <h2 class="text-5xl font-bold mb-4">El Mejor Café Artesanal</h2>
            <p class="text-lg mb-6 max-w-xl mx-auto">
                Disfruta de granos seleccionados con aroma y sabor inigualable. Directo del productor a tu taza.
            </p>
            <a href="#productos" class="bg-amber-700 px-6 py-3 rounded-lg font-semibold hover:bg-amber-600 transition">
                Ver Productos
            </a>
        </div>
    </section>

    <!-- Productos -->
    <section id="productos" class="py-20 max-w-7xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12 text-amber-800">Nuestros Productos</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Producto 1 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80" 
                     alt="Café Tostado" class="h-60 w-full object-cover">
                <div class="p-6">
                    <h4 class="text-xl font-semibold mb-2">Café Tostado</h4>
                    <p class="text-gray-600 mb-4">Notas a chocolate y caramelo. 100% arábica.</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-amber-700 text-lg">$25.000</span>
                        <a href="{{ route('cafe.comprar') }}" 
                           class="bg-amber-700 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition">
                           Agregar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Producto 2 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=800&q=80" 
                     alt="Café Molido" class="h-60 w-full object-cover">
                <div class="p-6">
                    <h4 class="text-xl font-semibold mb-2">Café Molido</h4>
                    <p class="text-gray-600 mb-4">Ideal para prensa francesa o máquina espresso.</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-amber-700 text-lg">$22.000</span>
                        <a href="{{ route('cafe.comprar') }}" 
                           class="bg-amber-700 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition">
                           Agregar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Producto 3 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80" 
                     alt="Café en Grano" class="h-60 w-full object-cover">
                <div class="p-6">
                    <h4 class="text-xl font-semibold mb-2">Café en Grano</h4>
                    <p class="text-gray-600 mb-4">Mantén la frescura y muele al momento.</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-amber-700 text-lg">$28.000</span>
                        <a href="{{ route('cafe.comprar') }}" 
                           class="bg-amber-700 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition">
                           Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nosotros -->
    <section id="nosotros" class="py-20 bg-amber-100 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h3 class="text-3xl font-bold text-amber-800 mb-6">Sobre Nosotros</h3>
            <p class="text-gray-700 leading-relaxed">
                En <strong>Café Aroma</strong> trabajamos directamente con caficultores colombianos que cultivan con pasión.
                Creemos en un comercio justo, en la sostenibilidad y en el sabor auténtico del café de montaña.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-amber-900 text-white py-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <p>&copy; 2025 Café Aroma. Todos los derechos reservados.</p>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-amber-300">Instagram</a>
                <a href="#" class="hover:text-amber-300">Facebook</a>
                <a href="#" class="hover:text-amber-300">WhatsApp</a>
            </div>
        </div>
    </footer>
</body>
