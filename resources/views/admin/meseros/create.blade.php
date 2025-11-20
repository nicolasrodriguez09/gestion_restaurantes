<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo mesero</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
                <ul class="list-disc ml-4 space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.meseros.store') }}" method="POST" class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-lg border px-3 py-2" required maxlength="255">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded-lg border px-3 py-2" required>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" class="mt-1 w-full rounded-lg border px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirmar password</label>
                    <input type="password" name="password_confirmation" class="mt-1 w-full rounded-lg border px-3 py-2" required>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.meseros.index') }}" class="rounded-lg border px-4 py-2">Cancelar</a>
                <button class="rounded-lg bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-700">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
