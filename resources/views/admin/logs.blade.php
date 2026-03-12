@extends('layouts.admin')
@section('title', 'System Logs')

@section('content')
    <h2 class="text-2xl font-bold mb-6">System Health & Logs</h2>
    <div class="bg-slate-900 text-green-400 p-6 rounded-lg font-mono text-sm shadow-xl">
        <p class="mb-2">[2024-05-20 10:15:02] local.INFO: Super Admin logged in.</p>
        <p class="mb-2">[2024-05-20 10:18:44] local.INFO: New tenant "Alpine Heights" created.</p>
        <p class="text-gray-500 italic">// Real-time logging stream would go here...</p>
    </div>
@endsection