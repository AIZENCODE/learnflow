@php
    $links = [
        [
            'name' => 'Dashboard',
            'href' => url('/dashboard'),
            'active' => request()->routeIs('dashboard'),
            'icon' =>
                'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
        ],

        [
            'name' => 'Empresas',
            'href' => url('/companies'),
            'active' => request()->routeIs('companies.*'),
            'icon' =>
                'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
        ],
        [
            'name' => 'Roles',
            'href' => url('/roles'),
            'active' => request()->routeIs('roles.*'),
          'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        ],
        [
            'name' => 'Usuarios',
            'href' => url('/users'),
            'active' => request()->routeIs('users.*'),
            'icon' =>
                'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        ],
        [
            'name' => 'Rutas',
            'href' => url('/tracks'),
            'active' => request()->routeIs('tracks.*'),
            'icon' =>
                'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
        ],
        [
            'name' => 'Cursos',
            'href' => url('/courses'),
            'active' => request()->routeIs('courses.*'),
            'icon' =>
                'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        ],

        [
            'name' => 'General',
            'href' => url('/general'),
            'active' => request()->routeIs('general.index'),
            'icon' =>
                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
    ];

    $company = App\Models\Company::first();
@endphp

<div id="sidebar"
    class="sidebar fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                @if ($company && $company->logo_path)
                    <img src="{{ asset($company->logo_path) }}"
                         alt="{{ $company->name }}"
                         class="h-8 w-auto dark:hidden">
                    @if($company->logo_path_dark)
                        <img src="{{ asset($company->logo_path_dark) }}"
                             alt="{{ $company->name }}"
                             class="h-8 w-auto hidden dark:block">
                    @else
                        <img src="{{ asset($company->logo_path) }}"
                             alt="{{ $company->name }}"
                             class="h-8 w-auto hidden dark:block">
                    @endif
                @else
                    <x-application-logo class="block h-8 w-auto fill-current" style="color: var(--color-one);" />
                @endif
                {{-- <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $company->name ?? 'Empresa' }}</span> --}}
            </div>
            <button id="sidebar-close"
                class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Body -->
        <div class="flex-1 overflow-y-auto py-4">
            <nav class="px-3 space-y-1">
                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}"
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ $link['active'] ? 'text-white shadow-lg' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        style="{{ $link['active'] ? 'background-color: var(--color-one);' : '' }}">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ $link['active'] ? 'text-white' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $link['icon'] }}" />
                        </svg>
                        <span>{{ $link['name'] }}</span>
                        @if ($link['active'])
                            <span class="ml-auto">
                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full flex items-center justify-center text-white font-semibold text-sm"
                        style="background-color: var(--color-one);">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay para móvil -->
<div id="sidebar-overlay"
    class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden transition-opacity duration-300 ease-linear"
    style="display: none; opacity: 0;"></div>
