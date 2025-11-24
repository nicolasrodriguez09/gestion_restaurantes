<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur border-b border-slate-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
                    <span class="text-lg font-semibold text-slate-900">DigiRest</span>
                </a>

                @php
                    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
                    $isMesero = auth()->check() && auth()->user()->role === 'mesero';
                @endphp

                <div class="hidden md:flex items-center gap-3 text-sm font-semibold">
                    <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-full {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Inicio</a>
                    @if($isAdmin)
                        <a href="{{ route('admin.mesas.index') }}" class="px-3 py-1.5 rounded-full {{ request()->routeIs('admin.mesas.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Mesas</a>
                        <a href="{{ route('admin.productos.index') }}" class="px-3 py-1.5 rounded-full {{ request()->routeIs('admin.productos.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Productos</a>
                        <a href="{{ route('admin.meseros.index') }}" class="px-3 py-1.5 rounded-full {{ request()->routeIs('admin.meseros.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Meseros</a>
                        <a href="{{ route('admin.cocina.index') }}" class="px-3 py-1.5 rounded-full {{ request()->routeIs('admin.cocina.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Cocina</a>
                    @endif
                    @if($isMesero)
                        <a href="{{ route('mesero.dashboard') }}" class="px-3 py-1.5 rounded-full {{ request()->routeIs('mesero.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Mesero</a>
                    @endif
                </div>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('profile.edit') }}" class="text-sm text-slate-600 hover:text-indigo-700">{{ __('Profile') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>

            <div class="md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="md:hidden hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-3 space-y-2 text-sm">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Inicio</a>
            @if($isAdmin)
                <a href="{{ route('admin.mesas.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.mesas.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Mesas</a>
                <a href="{{ route('admin.productos.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.productos.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Productos</a>
                <a href="{{ route('admin.meseros.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.meseros.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Meseros</a>
                <a href="{{ route('admin.cocina.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.cocina.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Cocina</a>
            @endif
            @if($isMesero)
                <a href="{{ route('mesero.dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('mesero.*') ? 'bg-indigo-100 text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }}">Mesero</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded text-slate-700 hover:bg-slate-100">{{ __('Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-3 py-2 rounded text-slate-700 hover:bg-slate-100">{{ __('Log Out') }}</button>
            </form>
        </div>
    </div>
</nav>
