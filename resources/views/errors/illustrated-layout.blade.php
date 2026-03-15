@extends('tenant.layouts.tenant')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-slate-100 mb-8">
                <span class="text-4xl">@yield('icon')</span>
            </div>

            <p class="text-xs font-black uppercase tracking-[0.3em] text-blue-600 mb-2">
                Error @yield('code')
            </p>

            <h1 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
                @yield('title')
            </h1>

            <p class="text-slate-500 text-lg mb-10 leading-relaxed">
                @yield('message')
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url()->previous() }}"
                    class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition shadow-sm">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Go Back
                </a>
                <a href="/dashboard"
                    class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                    Return Home
                </a>
            </div>
        </div>
    </div>
@endsection