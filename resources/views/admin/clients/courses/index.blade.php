<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Todos los Cursos') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Explora todos los cursos disponibles para ti
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
        @if ($courses->count() > 0)
            <div class="grid grid-cols-1 md:gap-3 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($courses as $course)
                    <div
                        class="group border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Imagen/Video del Curso -->
                        <div
                            class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden">
                            @if ( $course->image_path)
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
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No hay cursos disponibles</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Próximamente se agregarán nuevos cursos.</p>
            </div>
        @endif
    </div>
</x-tenancy-layout>

