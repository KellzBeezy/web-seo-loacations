@extends('tenant.layouts.tenant')

@section('content')
    <div class="md:flex md:items-center md:justify-between mb-10">
        <div class="flex-1 min-w-0">
            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:truncate">
                Welcome back, <span class="text-blue-600">{{ explode(' ', $user->name)[0] }}</span>! 👋
            </h2>
            <div class="flex items-center mt-2 text-slate-500">
                <i class="fa-solid fa-building-user mr-2 text-blue-400"></i>
                <p class="text-sm font-medium">Property: <span class="text-slate-800">Sunset Heights #402</span></p>
            </div>
        </div>
        @if(auth()->user()->hasPermission('add_location'))
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('locations.index') }}"
                    class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition-all transform hover:scale-105">
                    <i class="fa fa-plus mr-2 text-xs"></i> New Location
                </a>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div
            class="group bg-white overflow-hidden shadow-sm hover:shadow-xl rounded-2xl border border-slate-100 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 bg-blue-50 group-hover:bg-blue-600 rounded-xl p-4 transition-colors duration-300">
                        <i class="fa-solid fa-user-shield text-blue-600 group-hover:text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest">Account Status</dt>
                        <dd class="text-lg font-bold text-slate-900">Verified Tenant</dd>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="group bg-white overflow-hidden shadow-sm hover:shadow-xl rounded-2xl border border-slate-100 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 bg-green-50 group-hover:bg-green-600 rounded-xl p-4 transition-colors duration-300">
                        <i class="fa-solid fa-wallet text-green-600 group-hover:text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest">Monthly Rent</dt>
                        <dd class="text-lg font-bold text-slate-900">$1,250.00</dd>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="group bg-white overflow-hidden shadow-sm hover:shadow-xl rounded-2xl border border-slate-100 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 bg-orange-50 group-hover:bg-orange-600 rounded-xl p-4 transition-colors duration-300">
                        <i class="fa-solid fa-location-dot text-orange-600 group-hover:text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Locations</dt>
                        <dd class="flex items-baseline justify-between">
                            <div class="text-2xl font-black text-slate-900">{{ $locations->count() }}</div>
                            <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-lg">Live</span>
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10 grid grid-cols-1 gap-8 lg:grid-cols-2">
        <div class="bg-white shadow-sm border border-slate-100 rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900">Profile Details</h3>
                <i class="fa-solid fa-circle-info text-slate-300"></i>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-slate-400 uppercase">Full Name</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-slate-400 uppercase">Email Address</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm border border-slate-100 rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900">Recent Locations</h3>
                <a href="{{ route('locations.index') }}" class="text-xs font-bold text-blue-600 hover:underline">View
                    All</a>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-slate-50">
                    @forelse($locations->take(4) as $location)
                        <li class="p-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-lg bg-orange-50 flex items-center justify-center">
                                        <i class="fa-solid fa-map-pin text-orange-400 text-xs"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-bold text-slate-800">{{ $location->suburb }}</p>
                                        <p class="text-xs text-slate-400">{{ $location->city }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-black uppercase px-2 py-1 bg-slate-100 text-slate-500 rounded">
                                    {{ $location->change_frequency }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="p-10 text-center text-sm text-slate-400 italic">No locations added yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection