<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Essential import
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    /**
     * Show the form and the list of locations
     */
    public function index()
    {
        $locations = Location::latest()->paginate(5);
        $user = Auth::guard('tenant')->user();

        return view('tenant.locations.index', ['locations' => $locations, 'user' => $user]);
    }

    /**
     * Store a new location in the tenant's database
     */
    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'suburb' => [
                'required',
                'string',
                // This validates that the city/suburb combo is unique in the locations table
                Rule::unique('locations')->where(function ($query) use ($request) {
                    return $query->where('city', $request->city)
                        ->where('suburb', $request->suburb);
                }),
            ],
            'change_frequency' => 'required|string',
        ], [
            'suburb.unique' => 'This suburb already exists for the selected city.',
        ]);

        // Location::create($request->all());  

        Location::create($request->only([
            'change_frequency',
            'suburb',
            'city'
        ]));

        return redirect()->back()->with('success', 'Location added successfully!');
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'city' => 'required|string',
            'suburb' => [
                'required',
                'string',
                // Ensure unique combo check on update, ignoring current ID
                Rule::unique('locations')->where(fn($q) => $q->where('city', $request->city)->where('suburb', $request->suburb))->ignore($location->id)
            ],
            'change_frequency' => 'required|string',
        ]);

        $location->update($request->all());

        return back()->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return back()->with('success', 'Location removed successfully.');
    }
}


