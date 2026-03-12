<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Portal | {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-blue-600"><i
                            class="fa-solid fa-house-chimney mr-2"></i>MyHome</span>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="{{ route('tenant.dashboard') }}"
                            class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Dashboard</a>
                        <a href="#"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">My
                            Lease</a>
                        <a href="#"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Payments</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ $user->name }}</span>
                        <form action="{{ route('tenant.logout') }}" method="POST">
                            @csrf
                            <button
                                class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-md text-sm transition">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10 flex-grow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Property Management System. All rights reserved.
        </div>
    </footer>
</body>

</html>