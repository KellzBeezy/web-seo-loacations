@extends('admin.layouts.admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold">System Audit Logs</h2>
        <a href="{{ route('admin.activities.download') }}"
            class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm">Download CSV</a>
    </div>

    <div class="bg-slate-900 rounded-xl overflow-hidden shadow-2xl">
        <div class="p-6 font-mono text-xs space-y-2">
            @foreach($activities as $activity)
                <div class="flex gap-4 border-b border-slate-800 pb-2">
                    <span class="text-slate-500">[{{ $activity->created_at }}]</span>
                    <span
                        class="{{ $activity->getTerminalColor() }} w-20 inline-block">[{{ strtoupper($activity->level) }}]</span>
                    <span class="text-slate-300">{{ $activity->description }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        {{ $activities->links() }}
    </div>
@endsection