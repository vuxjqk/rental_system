<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'location_id' => $request->input('location_id'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'min_area' => $request->input('min_area'),
            'max_area' => $request->input('max_area'),
            'type' => $request->input('type'),
            'amenities' => $request->input('amenities', []),
            'sort_by' => $request->input('sort_by'),
            'sort_order' => $request->input('sort_order', 'asc'),
        ];

        $properties = Property::filter($filters)
            ->with(['location', 'amenities', 'images'])
            ->paginate(10);

        return view('tenant.properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        return view('tenant.properties.show', compact('property'));
    }
}
