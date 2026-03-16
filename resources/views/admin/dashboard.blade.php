@extends('admin.layouts.admin')
@section('title', 'Overview')

@section('content')
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Global Overview</h2>
            <p class="text-sm text-gray-500 mt-1">Real-time performance metrics for your ecosystem.</p>
        </div>
        <div class="flex gap-3">
            {{-- Export Report: Points to the download route --}}
            <a href="{{ route('admin.activities.download') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export Report
            </a>

            <a href="{{ route('admin.tenants') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-lg text-sm font-semibold text-white hover:bg-blue-700 transition shadow-md shadow-blue-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Tenant
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        @php
            $cards = [
                ['label' => 'Total Tenants', 'value' => $stats->total_tenants, 'color' => 'blue', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['label' => 'Active Users', 'value' => $stats->active_users, 'color' => 'indigo', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Total Revenue', 'value' => '$' . number_format($stats->total_revenue, 2), 'color' => 'green', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Open Tickets', 'value' => $stats->pending_tickets, 'color' => 'red', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z']
            ];
        @endphp

        @foreach($cards as $card)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-2 rounded-xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">+12%</span>
                </div>
                <p class="text-gray-500 text-sm font-medium">{{ $card['label'] }}</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Tenants Table --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Top Performing Tenants</h3>
                <div class="relative">
                    <input type="text" placeholder="Search tenants..."
                        class="pl-8 pr-4 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                            <th class="px-6 py-4">Organization</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Health</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tenants as $tenant)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center font-bold text-blue-600">
                                            {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $tenant->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $tenant->domain ?? 'standard-plan' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium {{ $tenant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ $tenant->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $tenant->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 max-w-[100px]">
                                        <div class="bg-blue-500 h-1.5 rounded-full shadow-sm shadow-blue-200"
                                            style="width: 75%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Dynamic Terminal Activity Log --}}
        <div class="bg-slate-900 rounded-2xl shadow-xl flex flex-col overflow-hidden border border-slate-800">
            <div class="px-5 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-900/50">
                <div class="flex gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-500/80"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-500/80"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-green-500/80"></div>
                </div>
                <span class="text-[10px] font-mono text-slate-500 uppercase tracking-widest">Live System Logs</span>
            </div>

            <div class="p-6 font-mono text-xs flex-grow overflow-y-auto max-h-[450px] space-y-3 custom-scrollbar">
                @forelse($activities as $activity)
                    <div class="flex gap-3">
                        <span class="text-slate-600 shrink-0">[{{ $activity->created_at->format('H:i:s') }}]</span>
                        <p class="leading-relaxed">
                            <span class="{{ $activity->getTerminalColor() }} font-bold uppercase mr-1">
                                {{ $activity->level }}:
                            </span>
                            <span class="text-slate-300">
                                <span class="text-blue-400">{{ $activity->user->name ?? 'SYSTEM' }}</span>
                                {{ $activity->description }}
                            </span>
                        </p>
                    </div>
                @empty
                    <div class="text-slate-600 italic py-4">// Listening for system events...</div>
                @endforelse
                <p class="text-green-400 animate-pulse">_</p>
            </div>

            <div class="p-4 bg-slate-800/30 mt-auto">
                {{-- Link to full logs index and download --}}
                <div class="flex flex-col gap-2">
                    <a href="{{ route('admin.activities.index') }}"
                        class="text-center text-[11px] font-bold text-blue-400 hover:text-blue-300 transition-colors uppercase tracking-wider">
                        View Full Activity Feed
                    </a>
                    <a href="{{ route('admin.activities.download') }}"
                        class="text-center text-[10px] font-bold text-slate-500 hover:text-white transition-colors uppercase tracking-wider">
                        Download History (.CSV)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
@endsection