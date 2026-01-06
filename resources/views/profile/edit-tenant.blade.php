<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Perfil') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Actualizar Información del Perfil -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Actualizar Contraseña -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Eliminar Cuenta -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-tenancy-layout>

