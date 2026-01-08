@php
    $title = config('app.name', 'Laravel');
    $title_section = isset($title_section) ? ' - ' . $title_section : '';
    try {
        if (Schema::hasTable('companies')) {
            $company = App\Models\Company::first();
            $title = $company->name ?? $title;
            $companyColor = $company->color_hex ?? '#000000';
        }
    } catch (Exception $e) {
        // Si hay error, mantener el título por defecto
        $title = config('app.name', 'Laravel');
        $companyColor = '#000000';
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <title>{{ $title }} {{ $title_section }} </title>

    @if($company && $company->favicon_path)
        <link rel="icon" href="{{ asset($company->favicon_path) }}" type="image/x-icon">
        @if($company->favicon_path_dark)
            <link rel="icon" href="{{ asset($company->favicon_path_dark) }}" type="image/x-icon" media="(prefers-color-scheme: dark)">
        @endif
    @else
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />




    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-one: {{ $companyColor }};
        }
        .main {
            display: flex;
            min-height: 100vh;
        }
        .btn__primary {
            background-color: var(--color-one);
        }
        .color__one {
            color: var(--color-one);
        }
        @media (max-width: 1023px) {
            .sidebar {
                position: fixed;
                z-index: 50;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <main class="main">
        @include('layouts.includes.admin.sidebar')
        <div class="flex-1 min-w-0 min-h-screen bg-gray-100 dark:bg-gray-900 lg:ml-0 overflow-hidden">
            <div class="flex flex-col h-[calc(100vh-1px)] overflow-y-auto">
                @include('layouts.includes.admin.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="px-4 sm:px-6 lg:px-8 py-6">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="py-12 px-4 sm:px-6 lg:px-8 ">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </main>

    @livewireScripts

    <script>
        // Sidebar toggle con JavaScript puro
        (function() {
            let sidebarOpen = window.innerWidth >= 1024;
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function updateSidebar() {
                if (sidebar) {
                    if (sidebarOpen || window.innerWidth >= 1024) {
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                    } else {
                        sidebar.classList.remove('translate-x-0');
                        sidebar.classList.add('-translate-x-full');
                    }
                }

                if (sidebarOverlay) {
                    if (sidebarOpen && window.innerWidth < 1024) {
                        sidebarOverlay.style.display = 'block';
                        setTimeout(() => {
                            sidebarOverlay.style.opacity = '1';
                        }, 10);
                    } else {
                        sidebarOverlay.style.opacity = '0';
                        setTimeout(() => {
                            sidebarOverlay.style.display = 'none';
                        }, 300);
                    }
                }

                if (sidebarToggle) {
                    const iconOpen = sidebarToggle.querySelector('.icon-open');
                    const iconClose = sidebarToggle.querySelector('.icon-close');
                    if (iconOpen && iconClose) {
                        if (sidebarOpen) {
                            iconOpen.style.display = 'none';
                            iconClose.style.display = 'block';
                        } else {
                            iconOpen.style.display = 'block';
                            iconClose.style.display = 'none';
                        }
                    }
                }
            }

            function toggleSidebar() {
                sidebarOpen = !sidebarOpen;
                updateSidebar();
            }

            function closeSidebar() {
                sidebarOpen = false;
                updateSidebar();
            }

            // Inicializar cuando el DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    updateSidebar();
                    if (sidebarToggle) {
                        sidebarToggle.addEventListener('click', toggleSidebar);
                    }
                    if (sidebarClose) {
                        sidebarClose.addEventListener('click', closeSidebar);
                    }
                    if (sidebarOverlay) {
                        sidebarOverlay.addEventListener('click', closeSidebar);
                    }
                });
            } else {
                updateSidebar();
                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', toggleSidebar);
                }
                if (sidebarClose) {
                    sidebarClose.addEventListener('click', closeSidebar);
                }
                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', closeSidebar);
                }
            }

            // Manejar cambios de tamaño de ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebarOpen = true;
                }
                updateSidebar();
            });
        })();
    </script>
</body>

</html>
