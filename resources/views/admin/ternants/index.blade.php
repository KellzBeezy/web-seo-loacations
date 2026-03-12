@extends('layouts.admin')
@section('title', 'Tenants')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Manage Tenants</h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ Add Tenant</button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600">Tenant Name</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600">Owner</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600">Created At</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($tenants as $tenant)
                    <tr>
                        <td class="px-6 py-4 font-medium">{{ $tenant->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $tenant->owner->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $tenant->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Active</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-gray-50">
            {{ $tenants->links() }}
        </div>
    </div>
@endsection