<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $track->name }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Explora y completa esta ruta de aprendizaje
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        @php
            $companyColor = $company->color_hex ?? '#8B0000';
        @endphp

        <!-- Sección Principal: Tarjeta Blanca con Información -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Imagen a la Izquierda -->
                <div class="relative h-64 lg:h-96 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                    @if($track->image_path)
                        <img src="{{ asset($track->image_path) }}"
                            alt="{{ $track->name }}"
                            class="w-full h-full object-cover">
                    @elseif($track->background_path)
                        <img src="{{ asset($track->background_path) }}"
                            alt="{{ $track->name }}"
                            class="w-full h-full object-cover">
                    @elseif($track->icon_path)
                        <div class="flex items-center justify-center h-full">
                            <img src="{{ asset($track->icon_path) }}"
                                alt="{{ $track->name }}"
                                class="w-32 h-32 object-contain">
                        </div>
                    @else
                        <div class="flex items-center justify-center h-full p-8">
                            <div class="text-center">
                                <div class="mb-4">
                                    <svg class="w-32 h-32 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                                    {{ $track->name }}
                                </h3>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Contenido a la Derecha -->
                <div class="p-8 lg:p-12 flex flex-col justify-between">
                    <div>
                        <!-- Título con Estrella -->
                        <div class="flex items-center gap-2 mb-4">
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $track->name }}
                            </h1>
                            <svg class="w-6 h-6" style="color: {{ $companyColor }};" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>

                        <!-- Descripción -->
                        @if($track->description)
                            <p class="text-gray-700 dark:text-gray-300 mb-8 leading-relaxed text-base">
                                {{ $track->description }}
                            </p>
                        @endif

                        <!-- Estadísticas del Curso -->
                        <div class="grid grid-cols-3 gap-4 mb-8">
                            <!-- Módulos -->
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $totalCourses }} módulos
                                </span>
                            </div>

                            <!-- Horas -->
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    @if($totalHours > 0)
                                        {{ $totalHours }} hora{{ $totalHours > 1 ? 's' : '' }}
                                    @else
                                        {{ $totalMinutes }} min
                                    @endif
                                </span>
                            </div>

                            <!-- Certificado -->
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Certificado</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 rounded-lg text-sm font-semibold text-white transition-all duration-200 hover:shadow-lg transform hover:scale-105"
                            style="background-color: {{ $companyColor }};">
                            Iniciar Ruta
                        </a>
                        <button
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 hover:shadow-lg border-2"
                            style="color: {{ $companyColor }}; border-color: {{ $companyColor }}; background-color: white;">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            Guardar Ruta
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección del Camino Visual -->
        <div class="relative" style="@if($track->background_path) background-image: url('{{ asset($track->background_path) }}'); background-size: cover; background-position: center; @else background-color: {{ $companyColor }}; @endif min-height: 400px; border-radius: 1rem; overflow: hidden;" id="learning-path-container">
            @if($track->background_path)
                <div class="absolute inset-0 bg-black bg-opacity-40" style="z-index: 1;"></div>
            @endif
            <!-- Canvas para dibujar el camino -->
            <canvas id="path-canvas" class="absolute inset-0 w-full h-full" style="z-index: 2;"></canvas>

            <!-- Estrellas representando los cursos -->
            <div class="relative h-full py-20 px-8" style="z-index: 3;">
                <div class="relative h-full" id="courses-container">
                    @foreach($track->courses as $index => $course)
                        @php
                            $isActive = $index === 0; // Primera estrella activa
                            $totalCourses = $track->courses->count();
                        @endphp
                        <div class="course-node absolute flex flex-col items-center transition-all duration-300"
                             data-index="{{ $index }}"
                             data-active="{{ $isActive ? 'true' : 'false' }}"
                             style="transform: translate(-50%, -50%);">
                            <!-- Círculo de progreso -->
                            <div class="relative mb-2 course-circle">
                                @if($isActive)
                                    <!-- Círculo exterior punteado animado -->
                                    <div class="absolute inset-0 rounded-full border-2 border-white border-dashed pulse-ring"
                                         style="width: 90px; height: 90px; margin: -15px;"></div>
                                    <!-- Círculo sólido -->
                                    <div class="rounded-full bg-white shadow-lg z-10 active-circle"
                                         style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                        <svg class="w-10 h-10" style="color: {{ $companyColor }};" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                @else
                                    <!-- Estrella inactiva -->
                                    <div class="rounded-full border-2 border-white border-opacity-40 inactive-circle"
                                         style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.15);">
                                        <svg class="w-8 h-8 text-white opacity-60" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <!-- Nombre del curso -->
                            <div class="hidden lg:block text-center mt-3">
                                <p class="text-xs text-white opacity-95 font-semibold max-w-[120px] truncate drop-shadow-md course-title">
                                    {{ $course->title }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <style>
            @keyframes pulse {
                0%, 100% {
                    opacity: 1;
                    transform: scale(1);
                }
                50% {
                    opacity: 0.6;
                    transform: scale(1.15);
                }
            }

            .pulse-ring {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            .course-node {
                cursor: pointer;
            }

            .course-node:hover .inactive-circle {
                background-color: rgba(255, 255, 255, 0.25) !important;
                transform: scale(1.1);
                transition: all 0.3s ease;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('learning-path-container');
                const canvas = document.getElementById('path-canvas');
                const ctx = canvas.getContext('2d');
                const courses = document.querySelectorAll('.course-node');

                // Ajustar tamaño del canvas
                function resizeCanvas() {
                    canvas.width = container.offsetWidth;
                    canvas.height = container.offsetHeight;
                    drawPath();
                }

                // Dibujar el camino que conecta las estrellas
                function drawPath() {
                    if (courses.length < 2) return;

                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    const points = [];
                    courses.forEach((course, index) => {
                        const rect = course.getBoundingClientRect();
                        const containerRect = container.getBoundingClientRect();
                        const x = rect.left + rect.width / 2 - containerRect.left;
                        const y = rect.top + rect.height / 2 - containerRect.top;
                        points.push({ x, y, index });
                    });

                    // Dibujar líneas curvas entre puntos
                    for (let i = 0; i < points.length - 1; i++) {
                        const current = points[i];
                        const next = points[i + 1];

                        // Calcular punto de control para la curva
                        const controlX = (current.x + next.x) / 2;
                        const controlY = Math.min(current.y, next.y) - 50; // Curva hacia arriba

                        // Dibujar línea punteada curva
                        ctx.strokeStyle = 'rgba(255, 255, 255, 0.8)';
                        ctx.lineWidth = 4;
                        ctx.setLineDash([12, 8]);
                        ctx.lineCap = 'round';

                        ctx.beginPath();
                        ctx.moveTo(current.x, current.y);
                        ctx.quadraticCurveTo(controlX, controlY, next.x, next.y);
                        ctx.stroke();

                        // Dibujar línea sólida más delgada debajo para efecto de profundidad
                        ctx.strokeStyle = 'rgba(255, 255, 255, 0.3)';
                        ctx.lineWidth = 6;
                        ctx.setLineDash([]);
                        ctx.beginPath();
                        ctx.moveTo(current.x, current.y + 2);
                        ctx.quadraticCurveTo(controlX, controlY + 2, next.x, next.y + 2);
                        ctx.stroke();
                    }

                    // Resetear line dash
                    ctx.setLineDash([]);
                }

                // Posicionar los cursos dinámicamente
                function positionCourses() {
                    const totalCourses = courses.length;
                    const containerHeight = container.offsetHeight;
                    const containerWidth = container.offsetWidth;
                    const padding = 100;
                    const availableWidth = containerWidth - (padding * 2);

                    courses.forEach((course, index) => {
                        const isActive = course.dataset.active === 'true';
                        const x = padding + (index / Math.max(1, totalCourses - 1)) * availableWidth;

                        // Crear una curva suave en la posición Y
                        const centerY = containerHeight / 2;
                        const amplitude = 40; // Altura de la curva
                        const frequency = Math.PI / (totalCourses - 1);
                        const y = centerY + Math.sin(index * frequency) * amplitude;

                        course.style.left = x + 'px';
                        course.style.top = y + 'px';
                    });

                    // Redibujar el camino después de posicionar
                    setTimeout(drawPath, 100);
                }

                // Inicializar
                resizeCanvas();
                positionCourses();

                // Redibujar al cambiar el tamaño de la ventana
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(function() {
                        resizeCanvas();
                        positionCourses();
                    }, 250);
                });

                // Redibujar cuando los elementos se carguen completamente
                window.addEventListener('load', function() {
                    setTimeout(function() {
                        resizeCanvas();
                        positionCourses();
                    }, 100);
                });
            });
        </script>

        <!-- Lista de Cursos de la Ruta -->
        @if($track->courses->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    Módulos de la Ruta
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($track->courses as $course)
                        <a href="{{ route('client.courses.show', $course) }}"
                           class="group border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            Módulo {{ $course->order_in_track ?? $loop->iteration }}
                                        </span>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $course->title }}
                                    </h4>
                                    @if($course->short_description)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4">
                                            {{ $course->short_description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                @if($course->lessons_count > 0)
                                    <span>{{ $course->lessons_count }} lecciones</span>
                                @endif
                                @if($course->duration_minutes)
                                    <span>{{ $course->duration_minutes }} min</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-tenancy-layout>

