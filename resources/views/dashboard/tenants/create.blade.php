<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Inquilino') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 border border-green-400 text-green-700 dark:text-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('tenants.store') }}">
                @csrf

                <div class="space-y-6">
                    <!-- ID del Inquilino -->
                    <div>
                        <x-input-label for="id">
                            {{ __('ID del Inquilino') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full"
                            :value="old('id')" required autofocus
                            placeholder="ejemplo: empresa1" />
                        <x-input-error class="mt-2" :messages="$errors->get('id')" />
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            El ID será usado para crear el dominio: <span class="font-mono">{{ old('id', 'ejemplo') }}.{{ env('APP_TENANT_DOMAIN') }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6 space-x-3">
                    <a href="{{ route('tenants.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Cancelar
                    </a>
                    <x-primary-button>
                        {{ __('Crear Inquilino') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
