<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Inquilinos') }}
            </h2>

            <x-enlace-button href="{{ route('tenants.create') }}" class="btn">

                Crear Inquilino
            </x-enlace-button>
        </div>
    </x-slot>

    <div class="">

        <div class="container">



            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Dominio
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Fecha de Creación
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($tenants as $tenant)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $tenant->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $tenant->domains->first()->domain ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($tenant->is_active)
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Activo
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $tenant->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Botón Ver -->


                                            <!-- Botón Editar (con color de empresa) -->
                                            <a href="{{ route('tenants.edit', $tenant->id) }}"
                                                class="inline-flex items-center px-4 py-1.5 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Editar
                                            </a>



                                            <!-- Botón Activar/Desactivar -->
                                            <button type="button"
                                                class="toggle-active-btn inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 transition {{ $tenant->is_active ? 'bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-500' : 'bg-green-500 hover:bg-green-600 focus:ring-green-500' }}"
                                                data-tenant-id="{{ $tenant->id }}"
                                                data-tenant-name="{{ $tenant->id }}"
                                                data-tenant-domain="{{ $tenant->domains->first()->domain ?? 'N/A' }}"
                                                data-is-active="{{ $tenant->is_active ? '1' : '0' }}">
                                                @if ($tenant->is_active)
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                                {{ $tenant->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>

                                            <!-- Botón Eliminar -->

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No hay inquilinos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                    {{ $tenants->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Modal de Confirmación de Activar/Desactivar -->
    <div id="toggle-active-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" style="display: none;">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75 transition-opacity" id="toggle-modal-overlay"></div>

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full transform transition-all opacity-0 scale-95" id="toggle-modal-content" style="transition: opacity 0.3s ease-out, transform 0.3s ease-out;">
                <div class="p-6">
                    <div id="toggle-modal-icon" class="flex items-center justify-center w-12 h-12 mx-auto rounded-full mb-4">
                        <!-- Icono se llenará dinámicamente -->
                    </div>

                    <h2 id="toggle-modal-title" class="text-xl font-semibold text-gray-900 dark:text-white text-center mb-2">
                        <!-- Título se llenará dinámicamente -->
                    </h2>

                    <p id="toggle-modal-description" class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                        <!-- Descripción se llenará dinámicamente -->
                    </p>

                    <div id="toggle-modal-info" class="rounded-lg p-4 mb-6">
                        <!-- Información se llenará dinámicamente -->
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" id="cancel-toggle-btn"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Cancelar
                        </button>
                        <form id="toggle-active-form" action="" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" id="confirm-toggle-btn"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
                                <!-- Texto se llenará dinámicamente -->
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-active-btn');
            const modal = document.getElementById('toggle-active-modal');
            const overlay = document.getElementById('toggle-modal-overlay');
            const cancelBtn = document.getElementById('cancel-toggle-btn');
            const modalContent = document.getElementById('toggle-modal-content');
            const form = document.getElementById('toggle-active-form');
            const modalIcon = document.getElementById('toggle-modal-icon');
            const modalTitle = document.getElementById('toggle-modal-title');
            const modalDescription = document.getElementById('toggle-modal-description');
            const modalInfo = document.getElementById('toggle-modal-info');
            const confirmBtn = document.getElementById('confirm-toggle-btn');

            // Abrir modal
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tenantId = this.getAttribute('data-tenant-id');
                    const tenantName = this.getAttribute('data-tenant-name');
                    const tenantDomain = this.getAttribute('data-tenant-domain');
                    const isActive = this.getAttribute('data-is-active') === '1';

                    // Configurar el formulario
                    form.action = `/tenants/${tenantId}/toggle-active`;

                    // Configurar el modal según la acción
                    if (isActive) {
                        // Desactivar
                        modalIcon.className = 'flex items-center justify-center w-12 h-12 mx-auto bg-yellow-100 dark:bg-yellow-900/20 rounded-full mb-4';
                        modalIcon.innerHTML = `
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        `;
                        modalTitle.textContent = '¿Desactivar Inquilino?';
                        modalDescription.textContent = 'El inquilino dejará de estar disponible y su dominio no funcionará.';
                        modalInfo.className = 'bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6';
                        modalInfo.innerHTML = `
                            <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span><strong>Inquilino:</strong> ${tenantName}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span><strong>Dominio:</strong> ${tenantDomain}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>El dominio <strong>no será accesible</strong> hasta que se reactive</span>
                                </li>
                            </ul>
                        `;
                        confirmBtn.className = 'inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150';
                        confirmBtn.innerHTML = `
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Desactivar
                        `;
                    } else {
                        // Activar
                        modalIcon.className = 'flex items-center justify-center w-12 h-12 mx-auto bg-green-100 dark:bg-green-900/20 rounded-full mb-4';
                        modalIcon.innerHTML = `
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        `;
                        modalTitle.textContent = '¿Activar Inquilino?';
                        modalDescription.textContent = 'El inquilino estará disponible y su dominio funcionará normalmente.';
                        modalInfo.className = 'bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6';
                        modalInfo.innerHTML = `
                            <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span><strong>Inquilino:</strong> ${tenantName}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span><strong>Dominio:</strong> ${tenantDomain}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>El dominio será <strong>accesible</strong> nuevamente</span>
                                </li>
                            </ul>
                        `;
                        confirmBtn.className = 'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150';
                        confirmBtn.innerHTML = `
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Activar
                        `;
                    }

                    // Mostrar modal
                    modal.classList.remove('hidden');
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                    void modal.offsetHeight;
                    setTimeout(() => {
                        modalContent.style.opacity = '1';
                        modalContent.style.transform = 'scale(1)';
                    }, 10);
                });
            });

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
