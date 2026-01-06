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
            <form method="POST" action="{{ $company->id ? route('companies.update', $company) : route('companies.store') }}">
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
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const colorPicker = document.getElementById('color_hex');
                                const colorText = document.getElementById('color_hex_text');

                                colorPicker.addEventListener('input', function() {
                                    colorText.value = this.value;
                                });

                                colorText.addEventListener('input', function() {
                                    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                                        colorPicker.value = this.value;
                                    }
                                });

                                colorText.addEventListener('change', function() {
                                    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                                        colorPicker.value = this.value;
                                    } else {
                                        this.value = colorPicker.value;
                                    }
                                });
                            });
                        </script>
                        <x-input-error class="mt-2" :messages="$errors->get('color_hex')" />
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
</x-tenancy-layout>
