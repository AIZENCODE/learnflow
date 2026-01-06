<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Todas las Rutas de Aprendizaje') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Explora todas las rutas disponibles para ti
                </p>
            </div>
            <a href="{{ route('general.index') }}"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors hover:underline"
                style="color: var(--color-one);">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="grid gap-6">
        @if ($tracks->count() > 0)
            <div class="grid grid-cols-1 md:gap-3 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($tracks as $track)
                    <div
                        class="group border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Imagen de la Ruta -->
                        <div
                            class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden">
                            @if ($track->image_path)
                                <img src="{{ asset($track->image_path) }}" alt="{{ $track->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @elseif($track->background_path)
                                <img src="{{ asset($track->background_path) }}" alt="{{ $track->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @elseif($track->icon_path)
                                <div class="flex items-center justify-center h-full">
                                    <img src="{{ asset($track->icon_path) }}" alt="{{ $track->name }}"
                                        class="w-24 h-24 object-contain">
                                </div>
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Contenido de la Ruta -->
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span
                                            class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            #{{ $track->order }}
                                        </span>
                                        @if ($track->has_time_limit)
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100">
                                                ⏱️ Tiempo Limitado
                                            </span>
                                        @endif
                                    </div>
                                    <h4
                                        class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $track->name }}
                                    </h4>
                                    @if ($track->description)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4">
                                            {{ $track->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Estadísticas de la Ruta -->
                            <div class="grid grid-cols-2 gap-4 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cursos</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ $track->courses_count }}
                                    </p>
                                </div>
                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Puntos XP</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ number_format($track->xp_points, 0) }}
                                    </p>
                                </div>
                            </div>

                            @if ($track->has_time_limit && ($track->start_date || $track->end_date))
                                <div
                                    class="mb-4 p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                                    <p class="text-xs font-semibold text-orange-800 dark:text-orange-200 mb-2">⏰ Período
                                        de Disponibilidad:</p>
                                    <div class="text-xs text-orange-700 dark:text-orange-300 space-y-1">
                                        @if ($track->start_date)
                                            <p>📅 Inicio: {{ $track->start_date->format('d/m/Y') }}</p>
                                        @endif
                                        @if ($track->end_date)
                                            <p>📅 Fin: {{ $track->end_date->format('d/m/Y') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Botón de Acción -->
                            <a href="{{ route('client.tracks.show', $track) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg text-sm font-semibold text-white transition-all duration-200 hover:shadow-lg transform hover:scale-105"
                                style="background-color: var(--color-one);">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                                Ver Ruta Completa
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No hay rutas disponibles</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Próximamente se agregarán nuevas rutas de
                    aprendizaje.</p>
            </div>
        @endif
    </div>
</x-tenancy-layout>
