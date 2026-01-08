<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Inquilino') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 border border-green-400 text-green-700 dark:text-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('tenants.update', $tenant->id) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- ID del Inquilino -->
                    <div>
                        <x-input-label for="id">
                            {{ __('ID del Inquilino') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full"
                            :value="old('id', $tenant->id)" required autofocus
                            placeholder="ejemplo: empresa1" />
                        <x-input-error class="mt-2" :messages="$errors->get('id')" />
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            El dominio se actualizará a: <span class="font-mono">{{ old('id', $tenant->id) }}.{{ env('APP_TENANT_DOMAIN') }}</span>
                        </p>
                    </div>

                    <!-- Información adicional -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Información del Inquilino</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label :value="__('Dominio Actual')" />
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">
                                    {{ $tenant->domains->first()->domain ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <x-input-label :value="__('Estado')" />
                                <div class="mt-1">
                                    @if($tenant->is_active)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Activo
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Inactivo
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <x-input-label :value="__('Fecha de Creación')" />
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $tenant->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <x-input-label :value="__('Última Actualización')" />
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $tenant->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <!-- Botón Eliminar -->
                    <button type="button" id="delete-tenant-btn"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Eliminar Inquilino
                    </button>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('tenants.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Cancelar
                        </a>
                        <x-primary-button>
                            {{ __('Actualizar Inquilino') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div id="delete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" style="display: none;">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75 transition-opacity" id="modal-overlay"></div>

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full transform transition-all opacity-0 scale-95" id="modal-content" style="transition: opacity 0.3s ease-out, transform 0.3s ease-out;">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/20 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white text-center mb-2">
                        ¿Eliminar Inquilino?
                    </h2>

                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                        Esta acción no se puede deshacer. Se eliminará permanentemente:
                    </p>

                    <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                        <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span><strong>El inquilino:</strong> {{ $tenant->id }}</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span><strong>El dominio:</strong> {{ $tenant->domains->first()->domain ?? 'N/A' }}</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span><strong>La base de datos del inquilino</strong> y todos sus datos</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span><strong>Todos los usuarios, cursos, lecciones y contenido</strong> asociados</span>
                            </li>
                        </ul>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" id="cancel-delete-btn"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Cancelar
                        </button>
                        <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" class="inline" id="delete-form">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>
                                Eliminar Permanentemente
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.getElementById('delete-tenant-btn');
            const modal = document.getElementById('delete-modal');
            const overlay = document.getElementById('modal-overlay');
            const cancelBtn = document.getElementById('cancel-delete-btn');
            const modalContent = document.getElementById('modal-content');

            // Abrir modal
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                    // Forzar reflow para que la animación funcione
                    void modal.offsetHeight;
                    // Animación de entrada
                    setTimeout(() => {
                        modalContent.style.opacity = '1';
                        modalContent.style.transform = 'scale(1)';
                    }, 10);
                });
            }

            // Cerrar modal
            function closeModal() {
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }, 300);
            }

            // Cerrar al hacer clic en cancelar
            if (cancelBtn) {
                cancelBtn.addEventListener('click', closeModal);
            }

            // Cerrar al hacer clic en overlay o fuera del contenido
            if (overlay) {
                overlay.addEventListener('click', closeModal);
            }

            // Cerrar al hacer clic fuera del contenido del modal
            modal.addEventListener('click', function(e) {
                if (e.target === modal || e.target === overlay) {
                    closeModal();
                }
            });

            // Cerrar con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Prevenir que el clic en el contenido del modal lo cierre
            if (modalContent) {
                modalContent.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</x-app-layout>
