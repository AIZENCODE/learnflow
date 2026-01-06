<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Curso') }}
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
            <form method="POST" action="{{ route('courses.update', $course) }}" class="">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Título -->
                    <div class="md:col-span-2">
                        <x-input-label for="title" :value="__('Título')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                            :value="old('title', $course->title)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <!-- Slug -->
                    <div class="md:col-span-2">
                        <x-input-label for="slug" :value="__('Slug (URL amigable)')" />
                        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full"
                            :value="old('slug', $course->slug)" placeholder="Se genera automáticamente si se deja vacío" />
                        <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Dejar vacío para generar automáticamente desde el título</p>
                    </div>

                    <!-- Descripción -->
                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('Descripción')" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('description', $course->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <!-- Descripción corta -->
                    <div class="md:col-span-2">
                        <x-input-label for="short_description" :value="__('Descripción Corta')" />
                        <textarea id="short_description" name="short_description" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('short_description', $course->short_description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('short_description')" />
                    </div>

                    <!-- Ruta -->
                    <div>
                        <x-input-label for="track_id" :value="__('Ruta')" />
                        <select id="track_id" name="track_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                            <option value="">Sin ruta</option>
                            @foreach($tracks as $track)
                                <option value="{{ $track->id }}" {{ old('track_id', $course->track_id) == $track->id ? 'selected' : '' }}>
                                    {{ $track->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('track_id')" />
                    </div>

                    <!-- Orden en ruta -->
                    <div>
                        <x-input-label for="order_in_track" :value="__('Orden en Ruta')" />
                        <x-text-input id="order_in_track" name="order_in_track" type="number" class="mt-1 block w-full"
                            :value="old('order_in_track', $course->order_in_track)" min="0" />
                        <x-input-error class="mt-2" :messages="$errors->get('order_in_track')" />
                    </div>

                    <!-- Tipo de media -->
                    <div>
                        <x-input-label for="show_media_type" :value="__('Tipo de Media')" />
                        <select id="show_media_type" name="show_media_type"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                            <option value="image" {{ old('show_media_type', $course->show_media_type) == 'image' ? 'selected' : '' }}>Imagen</option>
                            <option value="video" {{ old('show_media_type', $course->show_media_type) == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="none" {{ old('show_media_type', $course->show_media_type) == 'none' ? 'selected' : '' }}>Ninguno</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('show_media_type')" />
                    </div>

                    <!-- Duración -->
                    <div>
                        <x-input-label for="duration_minutes" :value="__('Duración (minutos)')" />
                        <x-text-input id="duration_minutes" name="duration_minutes" type="number" class="mt-1 block w-full"
                            :value="old('duration_minutes', $course->duration_minutes)" min="0" />
                        <x-input-error class="mt-2" :messages="$errors->get('duration_minutes')" />
                    </div>

                    <!-- Precio -->
                    <div>
                        <x-input-label for="price" :value="__('Precio')" />
                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
                            :value="old('price', $course->price)" min="0" required />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>

                    <!-- Puntos XP -->
                    <div>
                        <x-input-label for="xp_points" :value="__('Puntos de Experiencia')" />
                        <x-text-input id="xp_points" name="xp_points" type="number" step="0.01" class="mt-1 block w-full"
                            :value="old('xp_points', $course->xp_points)" min="0" required />
                        <x-input-error class="mt-2" :messages="$errors->get('xp_points')" />
                    </div>

                    <!-- Rutas de archivos -->
                    <div>
                        <x-input-label for="icon_path" :value="__('Ruta del Icono')" />
                        <x-text-input id="icon_path" name="icon_path" type="text" class="mt-1 block w-full"
                            :value="old('icon_path', $course->icon_path)" />
                        <x-input-error class="mt-2" :messages="$errors->get('icon_path')" />
                    </div>

                    <div>
                        <x-input-label for="image_path" :value="__('Ruta de la Imagen')" />
                        <x-text-input id="image_path" name="image_path" type="text" class="mt-1 block w-full"
                            :value="old('image_path', $course->image_path)" />
                        <x-input-error class="mt-2" :messages="$errors->get('image_path')" />
                    </div>

                    <div>
                        <x-input-label for="video_path" :value="__('Ruta del Video')" />
                        <x-text-input id="video_path" name="video_path" type="text" class="mt-1 block w-full"
                            :value="old('video_path', $course->video_path)" />
                        <x-input-error class="mt-2" :messages="$errors->get('video_path')" />
                    </div>

                    <!-- Checkboxes -->
                    <div class="md:col-span-2 space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_free" id="is_free" value="1"
                                {{ old('is_free', $course->is_free) ? 'checked' : '' }}
                                class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">¿Es gratuito?</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1"
                                {{ old('is_published', $course->is_published) ? 'checked' : '' }}
                                class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">¿Está publicado?</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="is_external_link" id="is_external_link" value="1"
                                {{ old('is_external_link', $course->is_external_link) ? 'checked' : '' }}
                                class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">¿Es solo un enlace externo?</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('courses.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        Cancelar
                    </a>
                    <x-primary-button style="background-color: var(--color-one);">
                        {{ __('Actualizar Curso') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-tenancy-layout>

