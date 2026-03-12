@extends('admin.layouts.admin')
@section('title', 'Overview')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Global Overview</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <p class="text-gray-500 text-sm">Total Tenants</p>
            <p class="text-2xl font-bold">{{ $stats->total_tenants }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <p class="text-gray-500 text-sm">Active Users</p>
            <p class="text-2xl font-bold">{{ $stats->active_users }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <p class="text-gray-500 text-sm">Total Revenue</p>
            <p class="text-2xl font-bold text-green-600">${{ number_format($stats->total_revenue, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <p class="text-gray-500 text-sm">Open Tickets</p>
            <p class="text-2xl font-bold text-red-500">{{ $stats->pending_tickets }}</p>
        </div>
    </div>
@endsection