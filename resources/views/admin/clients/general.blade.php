<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Mi Panel de Aprendizaje') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Explora rutas y cursos disponibles para ti
                </p>
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6">


        @php
            $bannerPath = $company->banner_path ?? null;
            $companyColor = $company->color_hex ?? '#6366f1';
            $hasBanner = !empty($bannerPath);
        @endphp
        <div class="">
            <div class="py-12 px-6 rounded-lg relative overflow-hidden"
                style="@if ($hasBanner) background-image: url('{{ asset($bannerPath) }}'); background-size: cover; background-position: center; @else background-color: {{ $companyColor }}; @endif">
                @if ($hasBanner)
                    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                @endif
                <div class="relative z-10">
                    <h1 class="text-white text-2xl font-bold drop-shadow-lg">Bienvenido <strong
                            class="color__one font-extrabold"
                            style="text-transform: capitalize;">{{ $user->name }}</strong></h1>
                </div>
            </div>
        </div>


        <!-- Estadísticas Generales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total de Rutas -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rutas Disponibles</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalTracks }}</p>
                    </div>
                    <div class="p-3 rounded-full" style="background-color: {{ $company->color_hex ?? '#000000' }}20;">
                        <svg class="w-8 h-8" style="color: var(--color-one);" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cursos Disponibles -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Cursos Disponibles</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $publishedCourses }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Progreso -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Mi Progreso</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">0%</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Puntos XP -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Puntos XP</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">0</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>




        <!-- Rutas de Aprendizaje -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        Rutas de Aprendizaje
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sigue una ruta estructurada para alcanzar tus objetivos
                    </p>
                </div>
                @if ($tracks->count() > 0)
                    <a href="{{ route('client.tracks.index') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-colors hover:underline"
                        style="color: var(--color-one);">
                        Ver todas las rutas →
                    </a>
                @endif
            </div>

            @if ($tracks->count() > 0)
                <div class="grid grid-cols-1 md:gap-3 md:grid-cols-2 lg:grid-cols-4 gap-4">
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
                                <div
                                    class="grid grid-cols-2 gap-4 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
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
                                        <p class="text-xs font-semibold text-orange-800 dark:text-orange-200 mb-2">⏰
                                            Período
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
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
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
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No hay rutas disponibles</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Próximamente se agregarán nuevas rutas de
                        aprendizaje.</p>
                </div>
            @endif
        </div>

        <!-- Cursos Disponibles -->
        @if ($courses->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Cursos Disponibles
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Explora y comienza a aprender con nuestros cursos
                        </p>
                    </div>
                    <a href="{{ route('client.courses.index') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-colors hover:underline"
                        style="color: var(--color-one);">
                        Ver todos los cursos →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:gap-3 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($courses as $course)
                        <div
                            class="group border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <!-- Imagen/Video del Curso -->
                            <div
                                class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden">
                                @if ($course->image_path)
                                    <img src="{{ asset($course->image_path) }}" alt="{{ $course->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @elseif($course->show_media_type === 'video' && $course->video_path)
                                    <video class="w-full h-full object-cover" muted>
                                        <source src="{{ asset($course->video_path) }}" type="video/mp4">
                                    </video>
                                @elseif($course->icon_path)
                                    <div class="flex items-center justify-center h-full">
                                        <img src="{{ asset($course->icon_path) }}" alt="{{ $course->title }}"
                                            class="w-24 h-24 object-contain">
                                    </div>
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Badges -->
                                {{-- <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    @if ($course->is_free)
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500 text-white shadow-lg">
                                            Gratis
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-500 text-white shadow-lg">
                                            ${{ number_format($course->price, 2) }}
                                        </span>
                                    @endif
                                    @if ($course->xp_points > 0)
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-500 text-white shadow-lg">
                                            +{{ number_format($course->xp_points, 0) }} XP
                                        </span>
                                    @endif
                                </div> --}}
                            </div>

                            <!-- Contenido del Curso -->
                            <div class="p-5">
                                <div class="mb-3">
                                    @if ($course->track)
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                            {{ $course->track->name }}
                                        </span>
                                    @endif
                                </div>

                                <h4
                                    class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $course->title }}
                                </h4>

                                @if ($course->short_description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4">
                                        {{ $course->short_description }}
                                    </p>
                                @endif

                                <!-- Información del Curso -->
                                <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-4">
                                    @if ($course->lessons_count > 0)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            <span>{{ $course->lessons_count }} Lecciones</span>
                                        </div>
                                    @endif
                                    @if ($course->duration_minutes)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $course->duration_minutes }} min</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Botón de Acción -->
                                <a href="{{ route('client.courses.show', $course) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg text-sm font-semibold text-white transition-all duration-200 hover:shadow-lg transform hover:scale-105"
                                    style="background-color: var(--color-one);">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Comenzar Curso
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</x-tenancy-layout>
