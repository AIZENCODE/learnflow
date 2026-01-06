<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Ruta') }}
            </h2>
        </div>
    </x-slot>

    <div class="">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 border border-green-400 text-green-700 dark:text-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('tracks.update', $track) }}" enctype="multipart/form-data" class="">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $track->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('Descripción')" />
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('description', $track->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <x-input-label for="order" :value="__('Orden')" />
                        <x-text-input id="order" name="order" type="number" class="mt-1 block w-full"
                            :value="old('order', $track->order)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('order')" />
                    </div>

                    <div>
                        <x-input-label for="xp_points" :value="__('Puntos de Experiencia')" />
                        <x-text-input id="xp_points" name="xp_points" type="number" step="0.01" class="mt-1 block w-full"
                            :value="old('xp_points', $track->xp_points)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('xp_points')" />
                    </div>

                    <!-- Campos de multimedia -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Multimedia</h3>
                    </div>

                    <div>
                        <x-input-label for="image_path" :value="__('Imagen')" />
                        @if($track->image_path)
                            <div class="mb-2">
                                <img src="{{ asset($track->image_path) }}" alt="Imagen actual" class="h-48 w-full object-cover rounded border border-gray-300 dark:border-gray-700" id="image_current">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Imagen actual</p>
                            </div>
                        @endif
                        <input id="image_path" name="image_path" type="file" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                            dark:file:bg-indigo-900 dark:file:text-indigo-300"
                            onchange="previewImage(this, 'image_preview', 'image_current')">
                        <x-input-error class="mt-2" :messages="$errors->get('image_path')" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formatos: JPEG, PNG, JPG, GIF, SVG, WEBP (máx. 4MB)</p>
                        <div class="mt-2">
                            <img id="image_preview" src="" alt="Vista previa de la nueva imagen"
                                class="h-48 w-full object-cover rounded border border-gray-300 dark:border-gray-700 hidden">
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 hidden" id="image_preview_label">Nueva imagen seleccionada</p>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="background_path" :value="__('Imagen de Fondo')" />
                        @if($track->background_path)
                            <div class="mb-2">
                                <img src="{{ asset($track->background_path) }}" alt="Fondo actual" class="h-48 w-full object-cover rounded border border-gray-300 dark:border-gray-700" id="background_current">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Fondo actual</p>
                            </div>
                        @endif
                        <input id="background_path" name="background_path" type="file" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                            dark:file:bg-indigo-900 dark:file:text-indigo-300"
                            onchange="previewImage(this, 'background_preview', 'background_current')">
                        <x-input-error class="mt-2" :messages="$errors->get('background_path')" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formatos: JPEG, PNG, JPG, GIF, SVG, WEBP (máx. 4MB)</p>
                        <div class="mt-2">
                            <img id="background_preview" src="" alt="Vista previa del nuevo fondo"
                                class="h-48 w-full object-cover rounded border border-gray-300 dark:border-gray-700 hidden">
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 hidden" id="background_preview_label">Nuevo fondo seleccionado</p>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="icon_path" :value="__('Icono')" />
                        @if($track->icon_path)
                            <div class="mb-2">
                                <img src="{{ asset($track->icon_path) }}" alt="Icono actual" class="h-24 w-24 object-contain rounded border border-gray-300 dark:border-gray-700" id="icon_current">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Icono actual</p>
                            </div>
                        @endif
                        <input id="icon_path" name="icon_path" type="file" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                            dark:file:bg-indigo-900 dark:file:text-indigo-300"
                            onchange="previewImage(this, 'icon_preview', 'icon_current')">
                        <x-input-error class="mt-2" :messages="$errors->get('icon_path')" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formatos: JPEG, PNG, JPG, GIF, SVG, WEBP (máx. 2MB)</p>
                        <div class="mt-2">
                            <img id="icon_preview" src="" alt="Vista previa del nuevo icono"
                                class="h-24 w-24 object-contain rounded border border-gray-300 dark:border-gray-700 hidden">
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 hidden" id="icon_preview_label">Nuevo icono seleccionado</p>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="video_path" :value="__('Video')" />
                        @if($track->video_path)
                            <div class="mb-2">
                                <video src="{{ asset($track->video_path) }}" class="w-full rounded border border-gray-300 dark:border-gray-700" controls style="max-height: 300px;" id="video_current"></video>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Video actual</p>
                            </div>
                        @endif
                        <input id="video_path" name="video_path" type="file" accept="video/*"
                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                            dark:file:bg-indigo-900 dark:file:text-indigo-300"
                            onchange="previewVideo(this, 'video_preview', 'video_current')">
                        <x-input-error class="mt-2" :messages="$errors->get('video_path')" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Formatos: MP4, WEBM, OGG (máx. 10MB)</p>
                        <div class="mt-2">
                            <video id="video_preview" controls class="w-full rounded border border-gray-300 dark:border-gray-700 hidden" style="max-height: 300px;">
                                Tu navegador no soporta la reproducción de videos.
                            </video>
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 hidden" id="video_preview_label">Nuevo video seleccionado</p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="has_time_limit" id="has_time_limit" value="1"
                                {{ old('has_time_limit', $track->has_time_limit) ? 'checked' : '' }}
                                onchange="toggleTimeLimitFields()"
                                class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">¿Tiene tiempo límite?</span>
                        </label>
                    </div>
                </div>

                <!-- Campos de tiempo límite -->
                <div id="time_limit_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: {{ old('has_time_limit', $track->has_time_limit) ? 'grid' : 'none' }};">
                    <div>
                        <x-input-label for="start_date" :value="__('Fecha de inicio')" />
                        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                            :value="old('start_date', $track->start_date?->format('Y-m-d'))" />
                        <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                    </div>

                    <div>
                        <x-input-label for="end_date" :value="__('Fecha de finalización')" />
                        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                            :value="old('end_date', $track->end_date?->format('Y-m-d'))" />
                        <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="time_limit_type" :value="__('Tipo de tiempo límite')" />
                        <select id="time_limit_type" name="time_limit_type"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                            <option value="self_paced" {{ old('time_limit_type', $track->time_limit_type) == 'self_paced' ? 'selected' : '' }}>Auto-paced</option>
                            <option value="from_enrollment" {{ old('time_limit_type', $track->time_limit_type) == 'from_enrollment' ? 'selected' : '' }}>Desde inscripción</option>
                            <option value="fixed_date" {{ old('time_limit_type', $track->time_limit_type) == 'fixed_date' ? 'selected' : '' }}>Fecha fija</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('time_limit_type')" />
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('tracks.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        Cancelar
                    </a>
                    <x-primary-button style="background-color: var(--color-one);">
                        {{ __('Actualizar Ruta') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Componente Livewire para gestionar cursos -->
        @livewire('track-courses', ['track' => $track->id])
    </div>

    <script>
        function toggleTimeLimitFields() {
            const checkbox = document.getElementById('has_time_limit');
            const fields = document.getElementById('time_limit_fields');
            if (checkbox.checked) {
                fields.style.display = 'grid';
            } else {
                fields.style.display = 'none';
            }
        }

        function previewImage(input, previewId, currentId = null) {
            const preview = document.getElementById(previewId);
            const previewLabel = document.getElementById(previewId + '_label');
            const current = currentId ? document.getElementById(currentId) : null;
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (previewLabel) {
                        previewLabel.classList.remove('hidden');
                    }
                    // Ocultar imagen actual si existe
                    if (current) {
                        current.style.opacity = '0.5';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                if (previewLabel) {
                    previewLabel.classList.add('hidden');
                }
                // Restaurar imagen actual si existe
                if (current) {
                    current.style.opacity = '1';
                }
            }
        }

        function previewVideo(input, previewId, currentId = null) {
            const preview = document.getElementById(previewId);
            const previewLabel = document.getElementById(previewId + '_label');
            const current = currentId ? document.getElementById(currentId) : null;
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const url = URL.createObjectURL(file);
                preview.src = url;
                preview.classList.remove('hidden');
                if (previewLabel) {
                    previewLabel.classList.remove('hidden');
                }
                // Ocultar video actual si existe
                if (current) {
                    current.style.opacity = '0.5';
                }
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                if (previewLabel) {
                    previewLabel.classList.add('hidden');
                }
                // Restaurar video actual si existe
                if (current) {
                    current.style.opacity = '1';
                }
            }
        }

        // Inicializar estado al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            toggleTimeLimitFields();
        });
    </script>
</x-tenancy-layout>

