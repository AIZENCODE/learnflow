<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $course->title }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Explora y completa las lecciones de este curso
                </p>
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6">
        @php
            $companyColor = $company->color_hex ?? '#6366f1';
            $totalDuration = $lessons->sum('duration_minutes');
        @endphp

        <!-- Sección de Overview del Curso -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 shadow-lg">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contenido del Curso -->
                <div class="flex flex-col justify-between">
                    <div>
                        <!-- Badge Ruta de Aprendizaje -->
                        @if($course->track)
                            <div class="mb-4">
                                <span class="inline-block px-4 py-2 text-xs font-bold rounded-full text-white shadow-md"
                                    style="background-color: {{ $companyColor }};">
                                    Ruta de aprendizaje
                                </span>
                            </div>
                        @endif

                        <!-- Título del Curso -->
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $course->title }}
                        </h1>

                        <!-- Descripción -->
                        @if($course->description)
                            <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                                {{ $course->description }}
                            </p>
                        @elseif($course->short_description)
                            <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                                {{ $course->short_description }}
                            </p>
                        @endif

                        <!-- Barra de Progreso -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">0% completado</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-300"
                                    style="background-color: {{ $companyColor }}; width: 0%;">
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas del Curso -->
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Lecciones -->
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $lessons->count() }} lecciones
                                </span>
                            </div>

                            <!-- Duración -->
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    @if($totalDuration >= 60)
                                        {{ floor($totalDuration / 60) }} hora{{ floor($totalDuration / 60) > 1 ? 's' : '' }}
                                    @else
                                        {{ $totalDuration }} min
                                    @endif
                                </span>
                            </div>

                            <!-- Certificado -->
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Certificado</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Imagen/Video del Curso -->
                <div class="flex items-center justify-center">
                    <div class="relative w-full h-64 lg:h-80 rounded-lg overflow-hidden shadow-xl">
                        @if($course->image_path)
                            <img src="{{ asset($course->image_path) }}"
                                alt="{{ $course->title }}"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 hover:bg-opacity-20 transition-all cursor-pointer">
                                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        @elseif($course->show_media_type === 'video' && $course->video_path)
                            <video class="w-full h-full object-cover" muted>
                                <source src="{{ asset($course->video_path) }}" type="video/mp4">
                            </video>
                        @elseif($course->icon_path)
                            <div class="flex items-center justify-center h-full bg-gray-200 dark:bg-gray-700">
                                <img src="{{ asset($course->icon_path) }}"
                                    alt="{{ $course->title }}"
                                    class="w-32 h-32 object-contain">
                            </div>
                        @else
                            <div class="flex items-center justify-center h-full bg-gray-200 dark:bg-gray-700">
                                <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Lecciones -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Tus lecciones
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Forja las habilidades necesarias para convertirte en un maestro del campo que elijas.
                </p>
            </div>

            @if($lessons->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($lessons as $lesson)
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-gray-700 dark:to-gray-600 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300">
                            <!-- Título de la Lección -->
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                                {{ $lesson->title }}
                            </h3>

                            <!-- Descripción -->
                            @if($lesson->description)
                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">
                                    {{ $lesson->description }}
                                </p>
                            @endif

                            <!-- Duración -->
                            <div class="flex items-center gap-2 mb-6">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $lesson->duration_minutes ?? 0 }} min
                                </span>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="flex flex-col gap-3">
                                <a href="#"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all duration-200 hover:shadow-lg transform hover:scale-105"
                                    style="background-color: {{ $companyColor }};">
                                    Iniciar Lección
                                </a>
                                <a href="#"
                                    class="w-full text-center px-4 py-2 text-sm font-medium transition-colors hover:underline"
                                    style="color: {{ $companyColor }};">
                                    Ver Contenido
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No hay lecciones disponibles</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Este curso aún no tiene lecciones publicadas.</p>
                </div>
            @endif
        </div>
    </div>
</x-tenancy-layout>

