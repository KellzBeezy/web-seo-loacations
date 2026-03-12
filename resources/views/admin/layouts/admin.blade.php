<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex min-h-screen">

    <aside class="w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col">
        <div class="p-6 text-xl font-bold border-b border-slate-800">AdminCore</div>
        <nav class="flex-grow p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="block py-2.5 px-4 rounded hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">
                <i class="fa fa-gauge mr-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.tenants') }}"
                class="block py-2.5 px-4 rounded hover:bg-slate-800 {{ request()->routeIs('admin.tenants') ? 'bg-blue-600' : '' }}">
                <i class="fa fa-users mr-2"></i> Manage Tenants
            </a>
            <a href="/super-admin/system-logs" class="block py-2.5 px-4 rounded hover:bg-slate-800">
                <i class="fa fa-terminal mr-2"></i> System Logs
            </a>
        </nav>
        <form action="/logout" method="POST" class="p-4 border-t border-slate-800">
            @csrf
            <button class="w-full text-left py-2.5 px-4 rounded hover:bg-red-600 transition">Logout</button>
        </form>
    </aside>

    <main class="flex-grow">
        <header class="bg-white shadow-sm p-4 flex justify-end">
            <span class="font-semibold text-gray-700">{{ $user->name }}</span>
        </header>
        <div class="p-8">
            @yield('content')
        </div>
    </main>
</body>

</html>