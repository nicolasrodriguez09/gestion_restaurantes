<x-guest-layout>
    <div class="space-y-3 border-b border-indigo-100 pb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Crear cuenta</p>
        <h1 class="text-3xl font-bold text-slate-900">Unete a DigiRest</h1>
        <p class="text-sm text-slate-600">Configura tu acceso para administrar mesas, pedidos y productos.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
        @csrf

        <div class="space-y-2">
            <x-input-label for="name" :value="__('Name')" class="text-slate-800 font-semibold" />
            <x-text-input
                id="name"
                class="w-full rounded-xl border-indigo-100 bg-white px-4 py-3 text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                placeholder="Nombre y apellido"
            />
            <x-input-error :messages="$errors->get('name')" class="text-sm text-indigo-700" />
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-slate-800 font-semibold" />
            <x-text-input
                id="email"
                class="w-full rounded-xl border-indigo-100 bg-white px-4 py-3 text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
                placeholder="equipo@digi.rest"
            />
            <x-input-error :messages="$errors->get('email')" class="text-sm text-indigo-700" />
        </div>

        <div class="space-y-2">
            <x-input-label for="password" :value="__('Password')" class="text-slate-800 font-semibold" />
            <x-text-input
                id="password"
                class="w-full rounded-xl border-indigo-100 bg-white px-4 py-3 text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Crea una contrasena segura"
            />
            <x-input-error :messages="$errors->get('password')" class="text-sm text-indigo-700" />
        </div>

        <div class="space-y-2">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-800 font-semibold" />
            <x-text-input
                id="password_confirmation"
                class="w-full rounded-xl border-indigo-100 bg-white px-4 py-3 text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Repite tu contrasena"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-sm text-indigo-700" />
        </div>

        <div class="flex items-center justify-between">
            <a class="text-sm font-semibold text-slate-600 hover:text-indigo-700" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-white"
            >
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
