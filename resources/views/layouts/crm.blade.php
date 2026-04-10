<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRM')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    @php
        $activityCustomer = request()->route('customer');
    @endphp

    <aside class="fixed inset-y-0 left-0 w-64 bg-indigo-800">
        <div class="flex h-16 items-center justify-center bg-indigo-600 text-lg font-bold tracking-wide text-white">
            CRM
        </div>

        <nav class="mt-4 px-3">
            <a href="{{ route('crm.dashboard') }}"
               class="mb-2 flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition {{ request()->routeIs('crm.dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                    <path d="M3 12l9-9 9 9" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5 10v10h14V10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('crm.customers.index') }}"
               class="mb-2 flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition {{ request()->routeIs('crm.customers.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Clientes
            </a>

            <a href="{{ route('crm.deals.index') }}"
               class="mb-2 flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition {{ request()->routeIs('crm.deals.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" />
                    <rect x="14" y="3" width="7" height="7" rx="1.5" />
                    <rect x="3" y="14" width="7" height="7" rx="1.5" />
                    <rect x="14" y="14" width="7" height="7" rx="1.5" />
                </svg>
                Pipeline
            </a>

            <a href="{{ $activityCustomer ? route('crm.customers.activities.index', $activityCustomer) : route('crm.customers.index') }}"
               title="{{ $activityCustomer ? 'Ver actividades' : 'Selecciona un cliente para ver sus actividades' }}"
               class="flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition {{ request()->routeIs('crm.customers.activities.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                    <path d="M8 2v4" stroke-linecap="round" />
                    <path d="M16 2v4" stroke-linecap="round" />
                    <rect x="3" y="6" width="18" height="15" rx="2" />
                    <path d="M3 10h18" />
                    <path d="M9 15l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Actividades
            </a>
        </nav>
    </aside>

    <main class="ml-64 min-h-screen">
        <header class="bg-white px-6 py-4 shadow-sm">
            @yield('page-title')
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
