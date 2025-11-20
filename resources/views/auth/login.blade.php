<x-guest-layout>
    <div class="space-y-3 border-b border-indigo-100 pb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Acceso seguro</p>
        <h1 class="text-3xl font-bold text-slate-900">Inicia sesion en DigiRest</h1>
        <p class="text-sm text-slate-600">Administra mesas, comandas y productos en tiempo real.</p>
    </div>

    <div class="mt-6 space-y-6">
        <x-auth-session-status class="rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-indigo-800" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" class="text-slate-800 font-semibold" />
                <x-text-input
                    id="email"
                    class="w-full rounded-xl border-indigo-100 bg-white px-4 py-3 text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="equipo@digi.rest"
                />
                <x-input-error :messages="$errors->get('email')" class="text-sm text-indigo-700" />
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" class="text-slate-800 font-semibold" />
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold text-indigo-700 hover:text-indigo-800" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <x-text-input
                    id="password"
                    class="w-full rounded-xl border-indigo-100 bg-white px-4 py-3 text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="********"
                />
                <x-input-error :messages="$errors->get('password')" class="text-sm text-indigo-700" />
            </div>

            <div class="flex items-center justify-between gap-3">
                <label for="remember_me" class="flex items-center gap-2 text-sm text-slate-700">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="h-4 w-4 rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500"
                        name="remember"
                    >
                    <span>{{ __('Remember me') }}</span>
                </label>
                <a href="{{ route('register') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-700">
                    &iquest;Aun no tienes cuenta?
                </a>
            </div>

            <button
                type="submit"
                class="inline-flex w-full justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-white"
            >
                {{ __('Log in') }}
            </button>
        </form>
    </div>
</x-guest-layout>
