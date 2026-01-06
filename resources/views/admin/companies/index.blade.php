@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-tenancy-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Empresa') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 border border-green-400 text-green-700 dark:text-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ $company->id ? route('companies.update', $company) : route('companies.store') }}" enctype="multipart/form-data">
                @csrf
                @if($company->id)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <x-input-label for="name">
                            {{ __('Nombre de la Empresa') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $company->name ?? '')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email', $company->email ?? '')"  />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <x-input-label for="phone" :value="__('Teléfono')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                            :value="old('phone', $company->phone ?? '')"  />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <x-input-label for="address" :value="__('Dirección')" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                            :value="old('address', $company->address ?? '')"  />
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>

                    <!-- Ciudad -->
                    <div>
                        <x-input-label for="city" :value="__('Ciudad')" />
                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                            :value="old('city', $company->city ?? '')"  />
                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                    </div>

                    <!-- Estado -->
                    <div>
                        <x-input-label for="state" :value="__('Estado')" />
                        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full"
                            :value="old('state', $company->state ?? '')"  />
                        <x-input-error class="mt-2" :messages="$errors->get('state')" />
                    </div>

                    <!-- Código Postal -->
                    <div>
                        <x-input-label for="zip" :value="__('Código Postal')" />
                        <x-text-input id="zip" name="zip" type="text" class="mt-1 block w-full"
                            :value="old('zip', $company->zip ?? '')"  />
                        <x-input-error class="mt-2" :messages="$errors->get('zip')" />
                    </div>

                    <!-- País -->
                    <div>
                        <x-input-label for="country" :value="__('País')" />
                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full"
                            :value="old('country', $company->country ?? '')"  />
                        <x-input-error class="mt-2" :messages="$errors->get('country')" />
                    </div>

                    <!-- Sitio Web -->
                    <div>
                        <x-input-label for="website" :value="__('Sitio Web')" />
                        <x-text-input id="website" name="website" type="url" class="mt-1 block w-full"
                            :value="old('website', $company->website ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('website')" />
                    </div>

                    <!-- Color Hexadecimal -->
                    <div>
                        <x-input-label for="color_hex" :value="__('Color')" />
                        <div class="mt-1 flex items-center gap-3">
                            <input id="color_hex" name="color_hex" type="color"
                                value="{{ old('color_hex', $company->color_hex ?? '#000000') }}"
                                class="h-10 w-20 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 cursor-pointer" />
                            <x-text-input id="color_hex_text" type="text"
                                :value="old('color_hex', $company->color_hex ?? '#000000')"
                                placeholder="#000000"
                                class="flex-1"
                                pattern="^#[0-9A-Fa-f]{6}$" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('color_hex')" />
                    </div>
                </div>

                <!-- Sección de Multimedia -->
                <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Multimedia</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Logo -->
                        <div>
                            <x-input-label for="logo_path" :value="__('Logo')" />
                            <div class="mt-1">
                                <input type="file" id="logo_path" name="logo_path" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-100 dark:hover:file:bg-gray-600"
                                    onchange="previewImage(this, 'logo_preview')">
                                <x-input-error class="mt-2" :messages="$errors->get('logo_path')" />
                                <div class="mt-2">
                                    @if($company->logo_path)
                                        <img id="logo_preview" src="{{ asset($company->logo_path) }}"
                                            alt="Logo actual" class="h-20 w-auto rounded border border-gray-300 dark:border-gray-700">
                                    @else
                                        <img id="logo_preview" src="" alt="Vista previa"
                                            class="h-20 w-auto rounded border border-gray-300 dark:border-gray-700 hidden">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Favicon -->
                        <div>
                            <x-input-label for="favicon_path" :value="__('Favicon')" />
                            <div class="mt-1">
                                <input type="file" id="favicon_path" name="favicon_path" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-100 dark:hover:file:bg-gray-600"
                                    onchange="previewImage(this, 'favicon_preview')">
                                <x-input-error class="mt-2" :messages="$errors->get('favicon_path')" />
                                <div class="mt-2">
                                    @if($company->favicon_path)
                                        <img id="favicon_preview" src="{{ asset($company->favicon_path) }}"
                                            alt="Favicon actual" class="h-16 w-16 rounded border border-gray-300 dark:border-gray-700">
                                    @else
                                        <img id="favicon_preview" src="" alt="Vista previa"
                                            class="h-16 w-16 rounded border border-gray-300 dark:border-gray-700 hidden">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Banner -->
                        <div>
                            <x-input-label for="banner_path" :value="__('Banner')" />
                            <div class="mt-1">
                                <input type="file" id="banner_path" name="banner_path" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-100 dark:hover:file:bg-gray-600"
                                    onchange="previewImage(this, 'banner_preview')">
                                <x-input-error class="mt-2" :messages="$errors->get('banner_path')" />
                                <div class="mt-2">
                                    @if($company->banner_path)
                                        <img id="banner_preview" src="{{ asset($company->banner_path) }}"
                                            alt="Banner actual" class="h-32 w-full object-cover rounded border border-gray-300 dark:border-gray-700">
                                    @else
                                        <img id="banner_preview" src="" alt="Vista previa"
                                            class="h-32 w-full object-cover rounded border border-gray-300 dark:border-gray-700 hidden">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Background -->
                        <div>
                            <x-input-label for="background_path" :value="__('Fondo')" />
                            <div class="mt-1">
                                <input type="file" id="background_path" name="background_path" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-100 dark:hover:file:bg-gray-600"
                                    onchange="previewImage(this, 'background_preview')">
                                <x-input-error class="mt-2" :messages="$errors->get('background_path')" />
                                <div class="mt-2">
                                    @if($company->background_path)
                                        <img id="background_preview" src="{{ asset($company->background_path) }}"
                                            alt="Fondo actual" class="h-32 w-full object-cover rounded border border-gray-300 dark:border-gray-700">
                                    @else
                                        <img id="background_preview" src="" alt="Vista previa"
                                            class="h-32 w-full object-cover rounded border border-gray-300 dark:border-gray-700 hidden">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Versiones Dark Mode -->
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Versiones Modo Oscuro</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Logo Dark -->
                            <div>
                                <x-input-label for="logo_path_dark" :value="__('Logo (Modo Oscuro)')" />
                                <div class="mt-1">
                                    <input type="file" id="logo_path_dark" name="logo_path_dark" accept="image/*"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-100 dark:hover:file:bg-gray-600"
                                        onchange="previewImage(this, 'logo_dark_preview')">
                                    <x-input-error class="mt-2" :messages="$errors->get('logo_path_dark')" />
                                    <div class="mt-2">
                                        @if($company->logo_path_dark)
                                            <img id="logo_dark_preview" src="{{ asset($company->logo_path_dark) }}"
                                                alt="Logo dark actual" class="h-20 w-auto rounded border border-gray-300 dark:border-gray-700">
                                        @else
                                            <img id="logo_dark_preview" src="" alt="Vista previa"
                                                class="h-20 w-auto rounded border border-gray-300 dark:border-gray-700 hidden">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Favicon Dark -->
                            <div>
                                <x-input-label for="favicon_path_dark" :value="__('Favicon (Modo Oscuro)')" />
                                <div class="mt-1">
                                    <input type="file" id="favicon_path_dark" name="favicon_path_dark" accept="image/*"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-100 dark:hover:file:bg-gray-600"
                                        onchange="previewImage(this, 'favicon_dark_preview')">
                                    <x-input-error class="mt-2" :messages="$errors->get('favicon_path_dark')" />
                                    <div class="mt-2">
                                        @if($company->favicon_path_dark)
                                            <img id="favicon_dark_preview" src="{{ asset($company->favicon_path_dark) }}"
                                                alt="Favicon dark actual" class="h-16 w-16 rounded border border-gray-300 dark:border-gray-700">
                                        @else
                                            <img id="favicon_dark_preview" src="" alt="Vista previa"
                                                class="h-16 w-16 rounded border border-gray-300 dark:border-gray-700 hidden">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Banner Dark -->
                            <div>
                                <x-input-label for="banner_path_dark" :value="__('Banner (Modo Oscuro)')" />
                                <div class="mt-1">
                                    <input type="file" id="banner_path_dark" name="banner_path_dark" accept="image/*"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-100 dark:hover:file:bg-gray-600"
                                        onchange="previewImage(this, 'banner_dark_preview')">
                                    <x-input-error class="mt-2" :messages="$errors->get('banner_path_dark')" />
                                    <div class="mt-2">
                                        @if($company->banner_path_dark)
                                            <img id="banner_dark_preview" src="{{ asset($company->banner_path_dark) }}"
                                                alt="Banner dark actual" class="h-32 w-full object-cover rounded border border-gray-300 dark:border-gray-700">
                                        @else
                                            <img id="banner_dark_preview" src="" alt="Vista previa"
                                                class="h-32 w-full object-cover rounded border border-gray-300 dark:border-gray-700 hidden">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Background Dark -->
                            <div>
                                <x-input-label for="background_path_dark" :value="__('Fondo (Modo Oscuro)')" />
                                <div class="mt-1">
                                    <input type="file" id="background_path_dark" name="background_path_dark" accept="image/*"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-100 dark:hover:file:bg-gray-600"
                                        onchange="previewImage(this, 'background_dark_preview')">
                                    <x-input-error class="mt-2" :messages="$errors->get('background_path_dark')" />
                                    <div class="mt-2">
                                        @if($company->background_path_dark)
                                            <img id="background_dark_preview" src="{{ asset($company->background_path_dark) }}"
                                                alt="Fondo dark actual" class="h-32 w-full object-cover rounded border border-gray-300 dark:border-gray-700">
                                        @else
                                            <img id="background_dark_preview" src="" alt="Vista previa"
                                                class="h-32 w-full object-cover rounded border border-gray-300 dark:border-gray-700 hidden">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button>
                        {{ __('Guardar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sincronización de color picker
        document.addEventListener('DOMContentLoaded', function() {
            const colorPicker = document.getElementById('color_hex');
            const colorText = document.getElementById('color_hex_text');

            if (colorPicker && colorText) {
                colorPicker.addEventListener('input', function() {
                    colorText.value = this.value;
                });

                colorText.addEventListener('input', function() {
                    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                        colorPicker.value = this.value;
                    }
                });

                colorText.addEventListener('change', function() {
                    if (!/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                        this.value = colorPicker.value;
                    }
                });
            }
        });

        // Función para vista previa de imágenes
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
</x-tenancy-layout>
