@extends('admin.layouts.admin')
@section('title', 'Tenants')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900">Manage Tenants</h2>
            <p class="text-slate-500 text-sm mt-1">Total of {{ $tenants->total() }} business accounts registered.</p>
        </div>
        
        <button class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition shadow-lg shadow-blue-200 flex items-center justify-center">
            <i class="fa fa-plus mr-2 text-sm"></i> Add New Tenant
        </button>
    </div>

    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                <i class="fa fa-search"></i>
            </span>
            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition sm:text-sm" placeholder="Search by name or owner...">
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Tenant Info</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Owner</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Created At</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tenants as $tenant)
                        <tr class="hover:bg-slate-50/50 transition duration-150 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold mr-3">
                                        {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">{{ $tenant->name }}</div>
                                        <div class="text-xs text-slate-400 font-medium tracking-tight">{{ $tenant->domain ?? 'no-domain.com' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-700 font-medium">{{ $tenant->owner->name ?? 'Unassigned' }}</div>
                                <div class="text-xs text-slate-400">{{ $tenant->owner->email ?? '---' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 font-medium">
                                {{ $tenant->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($tenant->is_active ?? true)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="#" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit Tenant">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete Tenant">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i class="fa fa-folder-open text-4xl mb-4 text-slate-200"></i>
                                <p>No tenants found in the system.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($tenants->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>
@endsection