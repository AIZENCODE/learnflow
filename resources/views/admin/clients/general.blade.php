<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Vista General') }}
            </h2>
        </div>
    </x-slot>

    <div class="">
        <!-- Estadísticas Generales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total de Rutas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Rutas</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalTracks }}</p>
                    </div>
                    <div class="p-3 rounded-full" style="background-color: {{ $company->color_hex ?? '#000000' }}20;">
                        <svg class="w-8 h-8" style="color: var(--color-one);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total de Cursos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Cursos</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalCourses }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cursos Publicados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Cursos Publicados</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $publishedCourses }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total de Usuarios -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Usuarios</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsers }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rutas de Aprendizaje -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Rutas de Aprendizaje
                </h3>
                <a href="{{ route('tracks.create') }}"
                    class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150"
                    style="background-color: var(--color-one);">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nueva Ruta
                </a>
            </div>

            @if($tracks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tracks as $track)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            #{{ $track->order }}
                                        </span>
                                        @if($track->has_time_limit)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100">
                                                Tiempo Limitado
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        {{ $track->name }}
                                    </h4>
                                    @if($track->description)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                            {{ $track->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Estadísticas de la Ruta -->
                            <div class="grid grid-cols-2 gap-4 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Cursos</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $track->courses_count }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Puntos XP</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($track->xp_points, 0) }}
                                    </p>
                                </div>
                            </div>

                            @if($track->has_time_limit && ($track->start_date || $track->end_date))
                                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Período:</p>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                        @if($track->start_date)
                                            <p>Inicio: {{ $track->start_date->format('d/m/Y') }}</p>
                                        @endif
                                        @if($track->end_date)
                                            <p>Fin: {{ $track->end_date->format('d/m/Y') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Acciones -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('tracks.show', $track) }}"
                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver
                                </a>
                                <a href="{{ route('tracks.edit', $track) }}"
                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white transition"
                                    style="background-color: var(--color-one);">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay rutas</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando tu primera ruta de aprendizaje.</p>
                    <div class="mt-6">
                        <a href="{{ route('tracks.create') }}"
                            class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150"
                            style="background-color: var(--color-one);">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Crear Ruta
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-tenancy-layout>
