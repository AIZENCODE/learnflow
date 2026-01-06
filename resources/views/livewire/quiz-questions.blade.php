<div x-data="{ 
         showMessage: false,
         message: '',
         messageType: 'success'
     }"
     @question-saved.window="showMessage = true; message = 'Pregunta guardada exitosamente'; messageType = 'success'; setTimeout(() => showMessage = false, 3000)"
     @question-deleted.window="showMessage = true; message = 'Pregunta eliminada exitosamente'; messageType = 'success'; setTimeout(() => showMessage = false, 3000)">
    
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

    <div class="flex justify-between items-center mb-4">
        <h4 class="text-md font-medium text-gray-900 dark:text-white">
            Preguntas del Quiz
        </h4>
        <button 
            type="button"
            wire:click="openQuestionModal"
            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
            style="background-color: var(--color-one);">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Agregar Pregunta
        </button>
    </div>

    @if($questions->count() > 0)
        <div class="space-y-4">
            @foreach($questions as $question)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Pregunta #{{ $loop->iteration }}</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100">
                                    {{ ucfirst(str_replace('_', ' ', $question->question_type)) }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Puntos: {{ $question->points }}</span>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ $question->question_text }}</p>
                            @if($question->explanation)
                                <p class="text-xs text-gray-600 dark:text-gray-400 italic">{{ $question->explanation }}</p>
                            @endif
                            
                            @if($question->questionOptions->count() > 0)
                                <div class="mt-3 space-y-1">
                                    @foreach($question->questionOptions->sortBy('order') as $option)
                                        <div class="flex items-center gap-2 text-sm">
                                            <span class="w-6 h-6 rounded-full flex items-center justify-center {{ $option->is_correct ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                                {{ $loop->iteration }}
                                            </span>
                                            <span class="flex-1 {{ $option->is_correct ? 'font-semibold text-green-700 dark:text-green-300' : 'text-gray-700 dark:text-gray-300' }}">
                                                {{ $option->option_text }}
                                            </span>
                                            @if($option->is_correct)
                                                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    Correcta
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                wire:click="openQuestionModal({{ $question->id }})"
                                class="p-1 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button
                                wire:click="deleteQuestion({{ $question->id }})"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta pregunta?')"
                                class="p-1 text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-sm text-gray-500 dark:text-gray-400">No hay preguntas en este quiz.</p>
        </div>
    @endif

    <!-- Modal para Pregunta -->
    @if($showQuestionModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: @entangle('showQuestionModal') }" x-show="open" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeQuestionModal"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full p-6 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $editingQuestion ? 'Editar Pregunta' : 'Nueva Pregunta' }}
                        </h3>
                        <button wire:click="closeQuestionModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveQuestion" class="space-y-4">
                        <div>
                            <x-input-label for="questionText" :value="__('Texto de la Pregunta')" />
                            <textarea id="questionText" wire:model="questionText" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('questionText')" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="questionType" :value="__('Tipo de Pregunta')" />
                                <select id="questionType" wire:model.live="questionType"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    <option value="multiple_choice">Opción Múltiple</option>
                                    <option value="multiple_answer">Múltiples Respuestas</option>
                                    <option value="true_false">Verdadero/Falso</option>
                                    <option value="short_answer">Respuesta Corta</option>
                                    <option value="essay">Ensayo</option>
                                    <option value="matching">Emparejamiento</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('questionType')" />
                            </div>

                            <div>
                                <x-input-label for="points" :value="__('Puntos')" />
                                <x-text-input id="points" wire:model="points" type="number" class="mt-1 block w-full" min="1" required />
                                <x-input-error class="mt-2" :messages="$errors->get('points')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="explanation" :value="__('Explicación (opcional)')" />
                            <textarea id="explanation" wire:model="explanation" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('explanation')" />
                        </div>

                        @php
                            $optionsTypes = ['multiple_choice', 'multiple_answer', 'true_false', 'matching'];
                            $needsOptions = in_array($questionType, $optionsTypes);
                        @endphp
                        
                        @if($needsOptions)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="flex justify-between items-center mb-3">
                                    <x-input-label for="options" :value="__('Opciones de Respuesta')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('options')" />
                                </div>

                                <!-- Agregar nueva opción -->
                                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div class="flex gap-2">
                                        <input 
                                            type="text" 
                                            wire:model="newOptionText"
                                            wire:keydown.enter.prevent="addOption"
                                            placeholder="Texto de la opción..."
                                            class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                        <label class="flex items-center px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <input type="checkbox" wire:model="newOptionIsCorrect" class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Correcta</span>
                                        </label>
                                        <button 
                                            type="button"
                                            wire:click="addOption"
                                            class="px-4 py-2 rounded-md text-sm font-medium text-white transition"
                                            style="background-color: var(--color-one);">
                                            Agregar
                                        </button>
                                    </div>
                                </div>

                                <!-- Lista de opciones -->
                                @if(count($options) > 0)
                                    <div class="space-y-2">
                                        @foreach($options as $index => $option)
                                            <div class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium {{ $option['is_correct'] ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-gray-200 text-gray-600 dark:bg-gray-600 dark:text-gray-300' }}">
                                                    {{ $index + 1 }}
                                                </span>
                                                <input 
                                                    type="text" 
                                                    wire:model="options.{{ $index }}.text"
                                                    class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                                <button 
                                                    type="button"
                                                    wire:click="toggleOptionCorrect({{ $index }})"
                                                    class="flex items-center px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                    <input 
                                                        type="{{ $questionType === 'multiple_answer' ? 'checkbox' : 'radio' }}"
                                                        @if($questionType !== 'multiple_answer')
                                                            name="correct_option"
                                                        @endif
                                                        {{ $option['is_correct'] ? 'checked' : '' }}
                                                        onclick="return false;"
                                                        class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 pointer-events-none">
                                                    <span class="ml-2 text-sm font-medium {{ $option['is_correct'] ? 'text-green-700 dark:text-green-300' : 'text-gray-700 dark:text-gray-300' }}">
                                                        Correcta
                                                    </span>
                                                </button>
                                                <button 
                                                    type="button"
                                                    wire:click="removeOption({{ $index }})"
                                                    class="p-2 text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Agrega opciones de respuesta arriba</p>
                                @endif
                            </div>
                        @endif

                        @if($questionType === 'short_answer')
                            <div>
                                <x-input-label for="correctTextAnswer" :value="__('Respuesta Correcta')" />
                                <x-text-input id="correctTextAnswer" wire:model="correctTextAnswer" type="text" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('correctTextAnswer')" />
                            </div>
                        @endif

                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" wire:click="closeQuestionModal"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancelar
                            </button>
                            <x-primary-button style="background-color: var(--color-one);">
                                {{ $editingQuestion ? 'Actualizar' : 'Crear' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

