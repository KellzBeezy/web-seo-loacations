<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans antialiased">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6 text-xl font-bold border-b border-slate-800">
                <i class="fa-solid fa-building-user mr-2 text-blue-400"></i> TenantHub
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <a href="#" class="block py-2.5 px-4 rounded bg-blue-600 text-white">
                    <i class="fa-solid fa-chart-line mr-2"></i> Dashboard
                </a>
                <a href="#" class="block py-2.5 px-4 rounded hover:bg-slate-800 transition">
                    <i class="fa-solid fa-file-invoice-dollar mr-2"></i> Payments
                </a>
                <a href="#" class="block py-2.5 px-4 rounded hover:bg-slate-800 transition">
                    <i class="fa-solid fa-wrench mr-2"></i> Maintenance
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                        class="w-full text-left py-2.5 px-4 rounded hover:bg-red-600 transition flex items-center">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-grow p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Welcome back, {{ $user->name }}!</h1>
                    <p class="text-gray-500">Here is what's happening with your tenancy today.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-800 leading-none">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                    <div
                        class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-blue-500 mb-2"><i class="fa-solid fa-calendar-check fa-2x"></i></div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Lease Status</h3>
                    <p class="text-2xl font-bold text-gray-800">Active</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-green-500 mb-2"><i class="fa-solid fa-wallet fa-2x"></i></div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Next Rent Due</h3>
                    <p class="text-2xl font-bold text-gray-800">In 12 Days</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-purple-500 mb-2"><i class="fa-solid fa-envelope fa-2x"></i></div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Contact Info</h3>
                    <p class="text-md font-semibold text-gray-800 truncate">{{ $user->email }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-gray-800">My Profile Information</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Verification Status</p>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold">Verified
                                Tenant</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

</html>