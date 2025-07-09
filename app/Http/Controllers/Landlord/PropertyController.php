<?php

namespace App\Http\Controllers\Landlord;

use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
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

        return view('landlord.properties.index', compact('properties', 'landlords', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        $amenities = Amenity::all();

        return view('landlord.properties.create', compact('locations', 'amenities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'address_detail' => 'required|string',
            'type' => 'required|in:single_room,shared_room,apartment,whole_house',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'max_occupants' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['landlord_id'] = Auth::id();

        $property = Property::create($validated);

        if (isset($validated['amenities'])) {
            $property->amenities()->sync($validated['amenities']);
        }

        if (isset($validated['images'])) {
            foreach ($validated['images'] as $image) {
                $imagePath = $image->store('property_images', 'public');
                $property->images()->create(['image_url' => $imagePath]);
            }
        }

        return redirect()->route('landlord.properties.show', $property)->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return view('landlord.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $locations = Location::all();
        $amenities = Amenity::all();

        return view('landlord.properties.edit', compact('property', 'locations', 'amenities'));
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
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['landlord_id'] = Auth::id();

        $property->update($validated);

        if (isset($validated['amenities'])) {
            $property->amenities()->sync($validated['amenities']);
        } else {
            $property->amenities()->detach();
        }

        if (isset($validated['images_to_delete'])) {
            foreach ($validated['images_to_delete'] as $imageId) {
                $image = $property->images()->find($imageId);
                if ($image) {
                    if (file_exists(public_path('storage/' . $image->image_url))) {
                        unlink(public_path('storage/' . $image->image_url));
                    }
                    $image->delete();
                }
            }
        }

        if (isset($validated['images'])) {
            foreach ($validated['images'] as $image) {
                $imagePath = $image->store('property_images', 'public');
                $property->images()->create(['image_url' => $imagePath]);
            }
        }

        return redirect()->route('landlord.properties.show', $property)->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        try {
            if ($property->images) {
                foreach ($property->images as $image) {
                    if (file_exists(public_path('storage/' . $image->image_url))) {
                        unlink(public_path('storage/' . $image->image_url));
                    }
                    $image->delete();
                }
            }

            $property->delete();
            return redirect()->route('landlord.properties.index')->with('success', 'Property deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('landlord.properties.index')->with('error', 'Failed to delete property: ' . $e->getMessage());
        }
    }
}
