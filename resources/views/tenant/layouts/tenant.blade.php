<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tenant Portal') | {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl md:text-2xl font-bold text-blue-600">
                            <i class="fa-solid fa-house-chimney mr-2"></i>MyHome
                        </span>
                    </div>

                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="{{ route('tenant.dashboard') }}"
                            class="{{ request()->routeIs('tenant.dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150">
                            Dashboard
                        </a>
                        <a href="#"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150">
                            My Lease
                        </a>
                        <a href="#"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150">
                            Payments
                        </a>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="hidden md:flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-600">{{ $user->name }}</span>
                        <form action="{{ route('tenant.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-600 p-2 rounded-full text-sm transition-colors border border-gray-100"
                                title="Logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>

                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                            <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden bg-white border-b border-gray-200">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('tenant.dashboard') }}"
                    class="{{ request()->routeIs('tenant.dashboard') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Dashboard
                </a>
                <a href="#"
                    class="border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    My Lease
                </a>
                <a href="#"
                    class="border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Payments
                </a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200 px-4">
                <div class="flex items-center px-3">
                    <div class="flex-shrink-0">
                        <div
                            class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ $user->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <form action="{{ route('tenant.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-6 md:py-10 flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Property Management System. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>