<div class="mt-6" 
     x-data="{ 
         showMessage: false,
         message: '',
         messageType: 'success'
     }"
     @course-added.window="showMessage = true; message = 'Curso agregado exitosamente'; messageType = 'success'; setTimeout(() => showMessage = false, 3000)"
     @course-removed.window="showMessage = true; message = 'Curso eliminado de la ruta exitosamente'; messageType = 'success'; setTimeout(() => showMessage = false, 3000)"
     @course-error.window="showMessage = true; message = $event.detail.message; messageType = 'error'; setTimeout(() => showMessage = false, 5000)">
    
    <div x-show="showMessage" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="mb-4 p-4 rounded"
         :class="messageType === 'success' ? 'bg-green-100 dark:bg-green-800 border border-green-400 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-800 border border-red-400 text-red-700 dark:text-red-300'"
         style="display: none;">
        <p x-text="message"></p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                Cursos de la Ruta
            </h3>
            <button 
                type="button"
                @click="$dispatch('open-add-course-modal')"
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                style="background-color: var(--color-one);">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Agregar Curso
            </button>
        </div>

        @if($trackCourses->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Orden
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Título
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($trackCourses as $course)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $course->order_in_track ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $course->title }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    @if($course->is_published)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                            Publicado
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            Borrador
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                    <button
                                        wire:click="removeCourse({{ $course->id }})"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este curso de la ruta?')"
                                        class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 shadow-sm text-xs font-medium rounded text-red-700 dark:text-red-400 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-sm text-gray-500 dark:text-gray-400">No hay cursos asignados a esta ruta.</p>
            </div>
        @endif
    </div>

    <!-- Modal para agregar curso -->
    <div 
        x-data="{ open: false }"
        @open-add-course-modal.window="open = true"
        @close-modal.window="open = false"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="$dispatch('close-modal')"></div>
            
            <!-- Modal -->
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Agregar Curso a la Ruta
                    </h3>
                    <button @click="$dispatch('close-modal')" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Buscador -->
                <div class="mb-4">
                    <input 
                        type="text" 
                        wire:model.live="search"
                        placeholder="Buscar curso..."
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                </div>

                <!-- Lista de cursos disponibles -->
                <div class="max-h-96 overflow-y-auto">
                    @if($this->availableCourses->count() > 0)
                        <div class="space-y-2">
                            @foreach($this->availableCourses as $course)
                                <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $course->title }}</p>
                                        @if($course->short_description)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ \Illuminate\Support\Str::limit($course->short_description, 60) }}</p>
                                        @endif
                                    </div>
                                    <button
                                        wire:click="addCourse({{ $course->id }})"
                                        @click="$dispatch('close-modal')"
                                        class="ml-4 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                                        style="background-color: var(--color-one);">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Agregar
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($search)
                                    No se encontraron cursos con "{{ $search }}"
                                @else
                                    No hay cursos disponibles para agregar
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

