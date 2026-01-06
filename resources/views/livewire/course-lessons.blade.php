<div class="mt-6" 
     x-data="{ 
         showMessage: false,
         message: '',
         messageType: 'success'
     }"
     @lesson-saved.window="showMessage = true; message = 'Lección guardada exitosamente'; messageType = 'success'; setTimeout(() => showMessage = false, 3000)"
     @lesson-deleted.window="showMessage = true; message = 'Lección eliminada exitosamente'; messageType = 'success'; setTimeout(() => showMessage = false, 3000)"
     @item-saved.window="showMessage = true; message = 'Item guardado exitosamente'; messageType = 'success'; setTimeout(() => showMessage = false, 3000)"
     @item-deleted.window="showMessage = true; message = 'Item eliminado exitosamente'; messageType = 'success'; setTimeout(() => showMessage = false, 3000)">
    
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
                Lecciones del Curso
            </h3>
            <button 
                type="button"
                wire:click="openLessonModal"
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                style="background-color: var(--color-one);">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Agregar Lección
            </button>
        </div>

        @if($lessons->count() > 0)
            <div class="space-y-4">
                @foreach($lessons as $lesson)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">#{{ $lesson->order }}</span>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $lesson->title }}</h4>
                                    @if($lesson->is_published)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                            Publicado
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            Borrador
                                        </span>
                                    @endif
                                </div>
                                @if($lesson->description)
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $lesson->description }}</p>
                                @endif
                                <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    <span>XP: {{ $lesson->xp_points }}</span>
                                    <span>Items: {{ $lesson->lessonItems->count() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button
                                    wire:click="openLessonModal({{ $lesson->id }})"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </button>
                                <button
                                    wire:click="deleteLesson({{ $lesson->id }})"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta lección?')"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Eliminar
                                </button>
                            </div>
                        </div>

                        <!-- Items de la lección -->
                        <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex justify-between items-center mb-3">
                                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Contenido de la Lección</h5>
                                <button
                                    wire:click="openItemModal({{ $lesson->id }})"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-white transition"
                                    style="background-color: var(--color-one);">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Agregar Item
                                </button>
                            </div>

                            @if($lesson->lessonItems->count() > 0)
                                <div class="space-y-2">
                                    @foreach($lesson->lessonItems->sortBy('order') as $item)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded">
                                            <div class="flex items-center gap-3 flex-1">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">#{{ $item->order }}</span>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->title }}</p>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-xs px-2 py-0.5 rounded bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100">
                                                            {{ ucfirst($item->content_type) }}
                                                        </span>
                                                        @if($item->content_type === 'quiz')
                                                            <button
                                                                wire:click="openQuestionsModal({{ $item->id }})"
                                                                class="text-xs px-2 py-0.5 rounded bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100 hover:bg-purple-200 dark:hover:bg-purple-700 transition">
                                                                Gestionar Preguntas
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button
                                                    wire:click="openItemModal({{ $lesson->id }}, {{ $item->id }})"
                                                    class="p-1 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <button
                                                    wire:click="deleteItem({{ $item->id }})"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este item?')"
                                                    class="p-1 text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No hay items en esta lección</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-sm text-gray-500 dark:text-gray-400">No hay lecciones en este curso.</p>
            </div>
        @endif
    </div>

    <!-- Modal para Lección -->
    @if($showLessonModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: @entangle('showLessonModal') }" x-show="open" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeLessonModal"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $editingLesson ? 'Editar Lección' : 'Nueva Lección' }}
                        </h3>
                        <button wire:click="closeLessonModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveLesson" class="space-y-4">
                        <div>
                            <x-input-label for="lessonTitle" :value="__('Título')" />
                            <x-text-input id="lessonTitle" wire:model="lessonTitle" type="text" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('lessonTitle')" />
                        </div>

                        <div>
                            <x-input-label for="lessonSlug" :value="__('Slug (opcional)')" />
                            <x-text-input id="lessonSlug" wire:model="lessonSlug" type="text" class="mt-1 block w-full" />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Se genera automáticamente si se deja vacío</p>
                            <x-input-error class="mt-2" :messages="$errors->get('lessonSlug')" />
                        </div>

                        <div>
                            <x-input-label for="lessonDescription" :value="__('Descripción')" />
                            <textarea id="lessonDescription" wire:model="lessonDescription" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('lessonDescription')" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="lessonOrder" :value="__('Orden')" />
                                <x-text-input id="lessonOrder" wire:model="lessonOrder" type="number" class="mt-1 block w-full" min="0" required />
                                <x-input-error class="mt-2" :messages="$errors->get('lessonOrder')" />
                            </div>

                            <div>
                                <x-input-label for="lessonXpPoints" :value="__('Puntos XP')" />
                                <x-text-input id="lessonXpPoints" wire:model="lessonXpPoints" type="number" step="0.1" class="mt-1 block w-full" min="0" required />
                                <x-input-error class="mt-2" :messages="$errors->get('lessonXpPoints')" />
                            </div>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="lessonIsPublished" 
                                    class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">¿Está publicado?</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" wire:click="closeLessonModal"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancelar
                            </button>
                            <x-primary-button style="background-color: var(--color-one);">
                                {{ $editingLesson ? 'Actualizar' : 'Crear' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal para Item -->
    @if($showItemModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: @entangle('showItemModal') }" x-show="open" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeItemModal"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full p-6 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $editingItem ? 'Editar Item' : 'Nuevo Item' }}
                        </h3>
                        <button wire:click="closeItemModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveItem" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <x-input-label for="itemTitle" :value="__('Título')" />
                                <x-text-input id="itemTitle" wire:model="itemTitle" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('itemTitle')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="itemDescription" :value="__('Descripción')" />
                                <textarea id="itemDescription" wire:model="itemDescription" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('itemDescription')" />
                            </div>

                            <div>
                                <x-input-label for="itemContentType" :value="__('Tipo de Contenido')" />
                                <select id="itemContentType" wire:model="itemContentType"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    <option value="video">Video</option>
                                    <option value="article">Artículo</option>
                                    <option value="quiz">Quiz</option>
                                    <option value="assignment">Tarea</option>
                                    <option value="download">Descarga</option>
                                    <option value="external_link">Enlace Externo</option>
                                    <option value="live_session">Sesión en Vivo</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('itemContentType')" />
                            </div>

                            <div>
                                <x-input-label for="itemCompletionType" :value="__('Tipo de Completado')" />
                                <select id="itemCompletionType" wire:model="itemCompletionType"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    <option value="automatic">Automático</option>
                                    <option value="quiz">Quiz</option>
                                    <option value="manual">Manual</option>
                                    <option value="text_answer">Respuesta de Texto</option>
                                    <option value="file_upload">Subida de Archivo</option>
                                    <option value="external">Externo</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('itemCompletionType')" />
                            </div>

                            <div>
                                <x-input-label for="itemOrder" :value="__('Orden')" />
                                <x-text-input id="itemOrder" wire:model="itemOrder" type="number" class="mt-1 block w-full" min="0" required />
                                <x-input-error class="mt-2" :messages="$errors->get('itemOrder')" />
                            </div>

                            <div>
                                <x-input-label for="itemXpPoints" :value="__('Puntos XP')" />
                                <x-text-input id="itemXpPoints" wire:model="itemXpPoints" type="number" step="0.1" class="mt-1 block w-full" min="0" required />
                                <x-input-error class="mt-2" :messages="$errors->get('itemXpPoints')" />
                            </div>

                            @if($itemContentType === 'video')
                                <div class="md:col-span-2">
                                    <x-input-label for="itemVideoUrl" :value="__('URL del Video')" />
                                    <x-text-input id="itemVideoUrl" wire:model="itemVideoUrl" type="url" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('itemVideoUrl')" />
                                </div>
                                <div>
                                    <x-input-label for="itemVideoDuration" :value="__('Duración (segundos)')" />
                                    <x-text-input id="itemVideoDuration" wire:model="itemVideoDuration" type="number" class="mt-1 block w-full" min="0" />
                                    <x-input-error class="mt-2" :messages="$errors->get('itemVideoDuration')" />
                                </div>
                            @endif

                            @if($itemContentType === 'article' || $itemContentType === 'assignment')
                                <div class="md:col-span-2">
                                    <x-input-label for="itemContent" :value="__('Contenido')" />
                                    <textarea id="itemContent" wire:model="itemContent" rows="6"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('itemContent')" />
                                </div>
                            @endif

                            @if($itemContentType === 'external_link')
                                <div class="md:col-span-2">
                                    <x-input-label for="itemExternalUrl" :value="__('URL Externa')" />
                                    <x-text-input id="itemExternalUrl" wire:model="itemExternalUrl" type="url" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('itemExternalUrl')" />
                                </div>
                            @endif

                            @if($itemContentType === 'download')
                                <div class="md:col-span-2">
                                    <x-input-label for="itemFilePath" :value="__('Ruta del Archivo')" />
                                    <x-text-input id="itemFilePath" wire:model="itemFilePath" type="text" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('itemFilePath')" />
                                </div>
                            @endif

                            <div class="md:col-span-2 space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="itemIsPreview" 
                                        class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">¿Es vista previa gratuita?</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="itemIsPublished" 
                                        class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">¿Está publicado?</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="itemRequiresCompletion" 
                                        class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">¿Requiere completado?</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" wire:click="closeItemModal"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancelar
                            </button>
                            <x-primary-button style="background-color: var(--color-one);">
                                {{ $editingItem ? 'Actualizar' : 'Crear' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal para Preguntas -->
    @if($showQuestionsModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: @entangle('showQuestionsModal') }" x-show="open" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeQuestionsModal"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full p-6 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Gestionar Preguntas del Quiz
                        </h3>
                        <button wire:click="closeQuestionsModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @livewire('quiz-questions', ['lessonItemId' => $selectedLessonId])
                </div>
            </div>
        </div>
    @endif
</div>

