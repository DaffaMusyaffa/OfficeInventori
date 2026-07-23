<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#1E293B',
                            blue: '#3B82F6',
                            green: '#10B981',
                            amber: '#F59E0B',
                            red: '#EF4444',
                            purple: '#8B5CF6',
                            light: '#F1F5F9',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
    <style>[x-cloak]{display:none}</style>
</head>
<body class="bg-brand-light font-sans text-slate-800 antialiased">
@php
    $isAdmin = auth()->user()->isAdmin();
    $menu = $isAdmin
        ? [
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home', 'active' => 'admin.dashboard'],
            ['route' => 'admin.items.index', 'label' => 'Barang', 'icon' => 'box', 'active' => 'admin.items.*'],
            ['route' => 'admin.requests.index', 'label' => 'Request', 'icon' => 'inbox', 'active' => 'admin.requests.*'],
            ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'users', 'active' => 'admin.users.*'],
            ['route' => 'admin.history', 'label' => 'Riwayat', 'icon' => 'clock', 'active' => 'admin.history'],
            ['route' => 'profile.edit', 'label' => 'Profile', 'icon' => 'user', 'active' => 'profile.*'],
        ]
        : [
            ['route' => 'employee.dashboard', 'label' => 'Dashboard', 'icon' => 'home', 'active' => 'employee.dashboard'],
            ['route' => 'employee.items.index', 'label' => 'Daftar Barang', 'icon' => 'box', 'active' => 'employee.items.*'],
            ['route' => 'employee.requests.create', 'label' => 'Buat Request', 'icon' => 'plus', 'active' => 'employee.requests.create'],
            ['route' => 'employee.requests.index', 'label' => 'Riwayat Saya', 'icon' => 'clock', 'active' => 'employee.requests.index'],
            ['route' => 'profile.edit', 'label' => 'Profile', 'icon' => 'user', 'active' => 'profile.*'],
        ];
@endphp

<div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">
    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-30 w-64 transform bg-brand-dark text-slate-300 transition-transform duration-200 lg:static lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="flex h-16 items-center gap-3 px-6">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-blue text-white">
                @include('partials.icon', ['name' => 'box', 'class' => 'h-5 w-5'])
            </div>
            <span class="text-sm font-semibold leading-tight text-white">Inventory<br>Request</span>
        </div>

        <nav class="mt-4 space-y-1 px-3">
            @foreach ($menu as $m)
                @php $active = request()->routeIs($m['active']); @endphp
                <a href="{{ route($m['route']) }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                          {{ $active ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    @include('partials.icon', ['name' => $m['icon'], 'class' => 'h-5 w-5 shrink-0'])
                    <span>{{ $m['label'] }}</span>
                </a>
            @endforeach

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                    @include('partials.icon', ['name' => 'logout', 'class' => 'h-5 w-5 shrink-0'])
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Overlay (mobile) -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-black/40 lg:hidden"></div>

    <!-- Main -->
    <div class="flex min-h-screen flex-1 flex-col">
        <!-- Topbar -->
        <header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 lg:px-8">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="text-slate-500 lg:hidden">
                    @include('partials.icon', ['name' => 'menu', 'class' => 'h-6 w-6'])
                </button>
                <h1 class="text-lg font-semibold text-slate-800">@yield('heading', 'Dashboard')</h1>
            </div>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-slate-100">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-blue text-sm font-semibold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="hidden text-sm font-medium text-slate-700 sm:block">{{ auth()->user()->name }}</span>
                    @include('partials.icon', ['name' => 'chevron-down', 'class' => 'h-4 w-4 text-slate-400'])
                </button>
                <div x-show="open" x-cloak @click.outside="open = false"
                     class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-200 bg-white py-1 shadow-lg">
                    <div class="border-b border-slate-100 px-4 py-2">
                        <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs capitalize text-slate-400">{{ auth()->user()->role }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-brand-red hover:bg-slate-50">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-8">
            @yield('content')
        </main>
    </div>

    <!-- Toast Notifications (bukan alert browser) -->
    <div class="pointer-events-none fixed right-4 top-4 z-50 flex w-full max-w-sm flex-col gap-3">
        @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
            @if (session($type))
                <div x-data="{ show: true }" x-show="show" x-cloak
                     x-init="setTimeout(() => show = false, 4000)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-8"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-x-8"
                     class="pointer-events-auto flex items-start gap-3 rounded-xl border border-{{ $color }}-200 bg-white p-4 shadow-lg">
                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-{{ $color }}-100 text-{{ $color }}-600">
                        @include('partials.icon', ['name' => $type === 'success' ? 'check' : 'x', 'class' => 'h-5 w-5'])
                    </div>
                    <div class="flex-1 pt-0.5 text-sm text-slate-700">{{ session($type) }}</div>
                    <button @click="show = false" class="text-slate-300 hover:text-slate-500">
                        @include('partials.icon', ['name' => 'x', 'class' => 'h-4 w-4'])
                    </button>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Modal Konfirmasi Global (menggantikan confirm() browser) -->
    <div x-data="{ open: false, title: '', message: '', danger: false, formEl: null }"
         x-cloak
         @confirm.window="open = true; title = $event.detail.title || 'Konfirmasi'; message = $event.detail.message || ''; danger = $event.detail.danger || false; formEl = $event.detail.form"
         x-show="open"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="open" x-transition.opacity @click="open = false" class="absolute inset-0 bg-slate-900/50"></div>
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full"
                     :class="danger ? 'bg-red-100 text-brand-red' : 'bg-blue-100 text-brand-blue'">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-slate-800" x-text="title"></h3>
                    <p class="mt-1 text-sm text-slate-500" x-text="message"></p>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <button @click="open = false"
                        class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                <button @click="open = false; if (formEl) formEl.submit()"
                        class="rounded-lg px-4 py-2 text-sm font-semibold text-white"
                        :class="danger ? 'bg-brand-red hover:bg-red-600' : 'bg-brand-blue hover:bg-blue-600'">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
