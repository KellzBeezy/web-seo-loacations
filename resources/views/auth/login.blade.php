<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($isAdmin) ? 'Admin' : 'Tenant' }} Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div
        class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border-t-4 {{ isset($isAdmin) ? 'border-red-600' : 'border-blue-600' }}">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">
            {{ isset($isAdmin) ? 'Super Admin Login' : 'Tenant Login' }}
        </h2>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- The action dynamically points to the current named route --}}
        <form method="POST" action="{{ url()->current() }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300"
                    placeholder="email@example.com" required>
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300"
                    placeholder="••••••••" required>
            </div>

            <button type="submit"
                class="w-full {{ isset($isAdmin) ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                Sign In to Dashboard
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="/" class="text-xs text-gray-400 hover:text-gray-600">Back to Home</a>
        </div>

        <p class="mt-6 text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </p>
    </div>

</body>

</html>