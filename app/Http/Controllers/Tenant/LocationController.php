<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Imports\LocationsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Enums\ChangeFrequency;

class LocationController extends Controller
{
    /**
     * Show the form and the list of locations
     */
    public function index()
    {
        $locations = Location::latest()->paginate(10);
        $user = Auth::user(); // Auth::user() is usually sufficient if guard is default

        return view('tenant.locations.index', compact('locations', 'user'));
    }

    /**
     * Store a new location
     */
    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'suburb' => [
                'required',
                'string',
                Rule::unique('locations')->where(function ($query) use ($request) {
                    return $query->where('city', $request->city)
                        ->where('suburb', $request->suburb);
                }),
            ],
            // Validate against Enum cases
            'change_frequency' => ['required', Rule::enum(ChangeFrequency::class)],
        ], [
            'suburb.unique' => 'This suburb already exists for the selected city.',
        ]);

        // Convert the string to an Enum case before saving
        $frequency = ChangeFrequency::tryFrom($request->change_frequency) ?? ChangeFrequency::WEEKLY;

        Location::create([
            'city' => $request->city,
            'suburb' => $request->suburb,
            'change_frequency' => $frequency,
        ]);

        return redirect()->back()->with('success', 'Location added successfully!');
    }

    /**
     * Bulk Store locations
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'locations' => 'required|array|min:1',
            'locations.*.city' => 'required|string|max:100',
            'locations.*.suburb' => 'required|string|max:100',
            'locations.*.change_frequency' => ['required', Rule::enum(ChangeFrequency::class)],
        ]);

        // dd($request->locations);

        foreach ($request->locations as $data) {
            // Normalize string to match Enum (e.g., "weekly" -> "Weekly")
            $normalizedFreq = ucfirst(strtolower($data['change_frequency']));

            $frequency = ChangeFrequency::tryFrom($normalizedFreq) ?? ChangeFrequency::WEEKLY;

            // dd($data, $frequency);

            Location::updateOrCreate(
                ['city' => $data['city'], 'suburb' => $data['suburb']],
                ['change_frequency' => $frequency->value]
            );
        }

        return back()->with('success', count($request->locations) . ' Locations processed successfully.');
    }

    /**
     * Update existing location
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'city' => 'required|string',
            'suburb' => [
                'required',
                'string',
                Rule::unique('locations')->where(fn($q) => $q->where('city', $request->city)->where('suburb', $request->suburb))->ignore($location->id)
            ],
            'change_frequency' => ['required', Rule::enum(ChangeFrequency::class)],
        ]);

        $frequency = ChangeFrequency::tryFrom($request->change_frequency) ?? ChangeFrequency::WEEKLY;

        $location->update([
            'city' => $request->city,
            'suburb' => $request->suburb,
            'change_frequency' => $frequency,
        ]);

        return back()->with('success', 'Location updated successfully.');
    }

    /**
     * Export Template
     */
    public function exportTemplate()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=location_template.csv",
        ];

        $columns = ['city', 'suburb', 'frequency'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['Johannesburg', 'Northcliff', 'Weekly']);
            fputcsv($file, ['Cape Town', 'Sea Point', 'Daily']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import from Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048',
        ]);

        try {
            Excel::import(new LocationsImport, $request->file('file'));
            return back()->with('success', 'Locations imported successfully!');
        } catch (\Exception $e) {
            // Log the error for yourself, but show a clean message to the user
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete location
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return back()->with('success', 'Location removed successfully.');
    }
}