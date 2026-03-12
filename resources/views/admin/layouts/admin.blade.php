<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-sans antialiased" x-data="{ mobileMenuOpen: false }">

    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="mobileMenuOpen = false"
        class="fixed inset-0 bg-slate-900/60 z-40 md:hidden"></div>

    <div class="flex min-h-screen">

        <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-white flex flex-col z-50 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex flex-shrink-0">

            <div class="p-6 text-xl font-bold border-b border-slate-800 flex justify-between items-center">
                <span class="tracking-wider">Admin<span class="text-blue-500">Core</span></span>
                <button @click="mobileMenuOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <i class="fa fa-times text-xl"></i>
                </button>
            </div>

            <nav class="flex-grow p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    <i class="fa fa-gauge w-6 text-center mr-2"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.tenants') }}"
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800 {{ request()->routeIs('admin.tenants') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    <i class="fa fa-users w-6 text-center mr-2"></i>
                    <span>Manage Tenants</span>
                </a>

                <a href="{{ route('admin.logs') }}"
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-slate-800 text-slate-400 hover:text-white">
                    <i class="fa fa-terminal w-6 text-center mr-2"></i>
                    <span>System Logs</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Settings
                </div>

                <a href="#"
                    class="flex items-center py-2.5 px-4 rounded text-slate-400 hover:bg-slate-800 hover:text-white transition duration-200">
                    <i class="fa fa-cog w-6 text-center mr-2"></i>
                    <span>Configuration</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center py-2.5 px-4 rounded text-slate-400 hover:bg-red-600 hover:text-white transition duration-200 group">
                        <i class="fa fa-sign-out-alt w-6 text-center mr-2 group-hover:scale-110"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-grow flex flex-col min-w-0">

            <header
                class="bg-white shadow-sm border-b h-16 flex items-center justify-between px-4 md:px-8 flex-shrink-0">
                <button @click="mobileMenuOpen = true"
                    class="md:hidden text-slate-600 hover:bg-slate-100 p-2 rounded-lg transition">
                    <i class="fa fa-bars text-xl"></i>
                </button>

                <div class="flex items-center ml-auto space-x-4">
                    <div class="flex flex-col text-right hidden sm:flex">
                        <span class="text-sm font-bold text-gray-800">{{ $user->name }}</span>
                        <span class="text-xs text-gray-500">Super Admin</span>
                    </div>

                    <div
                        class="h-10 w-10 rounded-full bg-slate-200 border-2 border-white shadow-sm flex items-center justify-center text-slate-600 font-bold overflow-hidden">
                        @if($user->avatar ?? false)
                            <img src="{{ $user->avatar }}" alt="avatar">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                </div>
            </header>

            <main class="flex-grow p-4 md:p-8 bg-gray-100">
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer class="bg-white border-t py-4 px-8 text-center text-gray-500 text-xs">
                &copy; {{ date('Y') }} {{ config('app.name') }} | Built with Laravel 12 & Tailwind
            </footer>
        </div>
    </div>
</body>

</html>