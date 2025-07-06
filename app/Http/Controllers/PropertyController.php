<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $landlords = User::all();
        $locations = Location::all();

        $properties = Property::query()
            ->with('landlord', 'location')
            ->filter($request->only(['landlord_id', 'location_id', 'status']))
            ->paginate(10);

        return view('properties.index', compact('properties', 'landlords', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $landlords = User::all();
        $locations = Location::all();
        return view('properties.create', compact('landlords', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'landlord_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
            'address_detail' => 'required|string',
            'type' => 'required|in:single_room,shared_room,apartment,whole_house',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'max_occupants' => 'required|integer|min:1',
            'status' => 'required|in:available,rented,maintenance',
            'description' => 'nullable|string',
        ]);

        $property = Property::create($validated);

        return redirect()->route('properties.show', $property)->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $landlords = User::all();
        $locations = Location::all();
        return view('properties.edit', compact('property', 'landlords', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'landlord_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
            'address_detail' => 'required|string',
            'type' => 'required|in:single_room,shared_room,apartment,whole_house',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'max_occupants' => 'required|integer|min:1',
            'status' => 'required|in:available,rented,maintenance',
            'description' => 'nullable|string',
        ]);

        $property->update($validated);

        return redirect()->route('properties.show', $property)->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        try {
            $property->delete();
            return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('properties.index')->with('error', 'Failed to delete property: ' . $e->getMessage());
        }
    }
}
