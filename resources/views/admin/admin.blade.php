<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin | Control Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">
        <aside class="w-72 bg-gray-900 text-gray-300 flex-shrink-0 flex flex-col shadow-xl">
            <div class="p-6 flex items-center space-x-3 bg-gray-800">
                <div class="bg-blue-500 p-2 rounded-lg text-white">
                    <i class="fa-solid fa-shield fa-lg"></i>
                </div>
                <span class="text-xl font-bold text-white tracking-tight">Admin<span
                        class="text-blue-400">Core</span></span>
            </div>

            <nav class="flex-grow p-4 space-y-1 overflow-y-auto">
                <p class="text-xs font-semibold text-gray-500 uppercase px-4 pb-2">Main Menu</p>
                <a href="#"
                    class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-blue-600/10 text-blue-400 border border-blue-600/20">
                    <i class="fa-solid fa-gauge"></i> <span>Global Overview</span>
                </a>
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-800 transition">
                    <i class="fa-solid fa-users"></i> <span>Manage Tenants</span>
                </a>
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-800 transition">
                    <i class="fa-solid fa-city"></i> <span>Properties</span>
                </a>

                <p class="text-xs font-semibold text-gray-500 uppercase px-4 pt-6 pb-2">System</p>
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-800 transition">
                    <i class="fa-solid fa-gears"></i> <span>System Settings</span>
                </a>
                <a href="#"
                    class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-800 transition text-red-400">
                    <i class="fa-solid fa-bug"></i> <span>Error Logs</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <form method="POST" action="/logout">
                    @csrf
                    <button
                        class="w-full flex items-center justify-center space-x-2 bg-gray-800 hover:bg-red-600 text-white py-2.5 rounded-lg transition">
                        <i class="fa-solid fa-power-off text-sm"></i>
                        <span>Secure Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-grow flex flex-col">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm">
                <div class="flex items-center bg-gray-100 px-3 py-1.5 rounded-full border border-gray-200">
                    <i class="fa-solid fa-search text-gray-400 mr-2"></i>
                    <input type="text" placeholder="Search system..."
                        class="bg-transparent border-none focus:ring-0 text-sm w-64">
                </div>
                <div class="flex items-center space-x-6">
                    <button class="relative text-gray-500 hover:text-blue-600 transition">
                        <i class="fa-solid fa-bell fa-lg"></i>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center">4</span>
                    </button>
                    <div class="h-8 w-[1px] bg-gray-200"></div>
                    <div class="flex items-center space-x-3 cursor-pointer group">
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600">{{ $user->name }}</p>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-red-500">Super Admin</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin&background=1e293b&color=fff"
                            class="h-10 w-10 rounded-full border-2 border-white ring-2 ring-gray-100">
                    </div>
                </div>
            </header>

            <div class="p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">System Statistics</h2>
                    <p class="text-gray-500 text-sm">Real-time performance metrics across all properties.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 relative overflow-hidden">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Revenue</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">$124,500</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-xl text-green-600"><i
                                    class="fa-solid fa-dollar-sign"></i></div>
                        </div>
                        <p class="text-xs text-green-600 mt-4"><i class="fa-solid fa-arrow-up mr-1"></i> 12% vs last
                            month</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Active Tenants</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">1,204</h3>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-xl text-blue-600"><i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-4">Across 42 locations</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Occupancy Rate</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">94.2%</h3>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-xl text-purple-600"><i class="fa-solid fa-house"></i>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 h-1.5 rounded-full mt-5">
                            <div class="bg-purple-500 h-1.5 rounded-full" style="width: 94%"></div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Open Tickets</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">18</h3>
                            </div>
                            <div class="bg-red-100 p-3 rounded-xl text-red-600"><i
                                    class="fa-solid fa-triangle-exclamation"></i></div>
                        </div>
                        <p class="text-xs text-red-500 mt-4">5 Urgent requests</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">Recent Tenant Logins</h3>
                        <button class="text-blue-600 text-sm font-semibold hover:underline">View All</button>
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-400 text-[11px] uppercase tracking-widest font-bold">
                            <tr>
                                <th class="px-6 py-3">Tenant Name</th>
                                <th class="px-6 py-3">Property</th>
                                <th class="px-6 py-3">Last Access</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                            <tr>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $user->name }} (You)</td>
                                <td class="px-6 py-4">Global Hub</td>
                                <td class="px-6 py-4">Just Now</td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-md text-gray-600 transition">Inspect</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>

</html>