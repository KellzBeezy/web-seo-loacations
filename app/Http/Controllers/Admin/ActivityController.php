<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityController extends Controller
{
    /**
     * Display a paginated list of all system activities.
     */
    public function index(Request $request)
    {
        $activities = Activity::with('user', 'AppTenant')
            ->latest()
            ->when($request->level, function ($query, $level) {
                return $query->where('level', $level);
            })
            ->paginate(50); // Show 50 per page for a "terminal" feel

        return view('admin.activities.index', ['activities' => $activities, 'user' => auth()->user()]);
    }

    /**
     * Export all logs to a CSV file.
     */
    public function download()
    {
        $fileName = 'system_logs_' . now()->format('Y-m-d_Hi') . '.csv';
        $activities = Activity::with('user')->orderBy('created_at', 'desc')->cursor();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($activities) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Timestamp', 'Level', 'User', 'Tenant ID', 'Description']);

            foreach ($activities as $log) {
                fputcsv($file, [
                    $log->created_at,
                    strtoupper($log->level),
                    $log->user->name ?? 'SYSTEM',
                    $log->tenant_id ?? 'N/A',
                    $log->description,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}