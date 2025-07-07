<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use User;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contracts = Contract::all();
        $tenants = User::all();

        return view('invoices.create', compact('contracts', 'tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'tenant_id' => 'required|exists:users,id',
            'descriptions' => 'required|array',
            'descriptions.*' => 'string|max:100',
            'amounts' => 'required|array',
            'amounts.*' => 'numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'contract_id' => $validated['contract_id'],
            'tenant_id' => $validated['tenant_id'],
            'total_amount' => array_sum($validated['amounts']),
            'due_date' => now()->addDays(30),
            'status' => 'pending',
        ]);

        foreach ($validated['descriptions'] as $index => $description) {
            $invoice->items()->create([
                'description' => $description,
                'amount' => $validated['amounts'][$index],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $contracts = Contract::all();
        $tenants = User::all();

        return view('invoices.edit', compact('invoice', 'contracts', 'tenants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'tenant_id' => 'required|exists:users,id',
            'descriptions' => 'required|array',
            'descriptions.*' => 'string|max:100',
            'amounts' => 'required|array',
            'amounts.*' => 'numeric|min:0',
        ]);

        $invoice->update([
            'contract_id' => $validated['contract_id'],
            'tenant_id' => $validated['tenant_id'],
            'total_amount' => array_sum($validated['amounts']),
            'status' => 'pending',
        ]);

        foreach ($invoice->items as $item) {
            $item->delete();
        }

        foreach ($validated['descriptions'] as $index => $description) {
            $invoice->items()->create([
                'description' => $description,
                'amount' => $validated['amounts'][$index],
            ]);
        }

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->items()->delete();
            $invoice->delete();
            return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Failed to delete invoice: ' . $e->getMessage());
        }
    }
}
