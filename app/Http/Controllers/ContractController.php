<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenants = User::where('role', 'tenant')->get();
        $landlords = User::where('role', 'landlord')->get();

        $contract = Contract::query()
            ->with('tenant', 'landlord')
            ->filter($request->only(['tenant_id', 'landlord_id', 'status']))
            ->paginate(10);

        return view('contracts.index', compact('contract', 'tenants', 'landlords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::where('status', 'available')->get();
        $tenants = User::where('role', 'tenant')->get();
        $landlords = User::where('role', 'landlord')->get();

        return view('contracts.create', compact('properties', 'tenants', 'landlords'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:users,id',
            'landlord_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'deposit' => 'required|numeric|min:0',
            'monthly_rent' => 'required|numeric|min:0',
            'contract_file_url' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('contract_file_url')) {
            $filePath = $request->file('contract_file_url')->store('contracts', 'public');
            $validated['contract_file_url'] = $filePath;
        }

        $contract = Contract::create($validated);

        $property = Property::find($validated['property_id']);
        $property->update([
            'status' => 'rented',
        ]);

        return redirect()->route('contracts.show', $contract)->with('success', 'Contract created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $properties = Property::all();
        $tenants = User::where('role', 'tenant')->get();
        $landlords = User::where('role', 'landlord')->get();

        return view('contracts.edit', compact('contract', 'properties', 'tenants', 'landlords'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:users,id',
            'landlord_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'deposit' => 'required|numeric|min:0',
            'monthly_rent' => 'required|numeric|min:0',
            'status' => 'required|in:active,terminated,expired',
            'contract_file_url' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'remove_contract_file' => 'nullable|boolean',
        ]);

        if ($request->hasFile('contract_file_url')) {
            if ($contract->contract_file_url) {
                Storage::disk('public')->delete($contract->contract_file_url);
            }

            $filePath = $request->file('contract_file_url')->store('contracts', 'public');
            $validated['contract_file_url'] = $filePath;
        } elseif ($request->remove_contract_file) {
            if ($contract->contract_file_url) {
                Storage::disk('public')->delete($contract->contract_file_url);
                $validated['contract_file_url'] = null;
            }
        }

        $contract->update($validated);

        $property = Property::find($validated['property_id']);
        if ($validated['status'] === 'terminated' || $validated['status'] === 'expired') {
            $status = 'available';
        } else {
            $status = 'rented';
        }
        $property->update([
            'status' => $status,
        ]);

        return redirect()->route('contracts.show', $contract)->with('success', 'Contract updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        try {
            if ($contract->contract_file_url) {
                Storage::disk('public')->delete($contract->contract_file_url);
            }

            $property = Property::find($contract->property_id);
            $property->update([
                'status' => 'available',
            ]);

            $contract->delete();
            return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('contracts.index')->with('error', 'Failed to delete contract: ' . $e->getMessage());
        }
    }
}
