<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $organization = $user->organization;

        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->update(['organization_id' => $organization->id]);
            $user->refresh();
            $organization = $user->organization;
        }

        $customers = $organization->customers()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization;

        // **FIX:** Ensure the organization exists before validation.
        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->organization_id = $organization->id;
            $user->save();
            $user->refresh();
            $organization = $user->organization;
        }
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('customers')->where(function ($query) use ($organization) {
                return $query->where('organization_id', $organization->id);
            })],
            'phone' => 'nullable|string|max:20',
            'contact_type' => 'required|string|in:individual,business',
            'primary_contact' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'tax_id_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $organization->customers()->create($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        if ($customer->organization_id !== Auth::user()->organization_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        if ($customer->organization_id !== Auth::user()->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        $organization = Auth::user()->organization;
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('customers')->where(function ($query) use ($organization) {
                return $query->where('organization_id', $organization->id);
            })->ignore($customer->id)],
            'phone' => 'nullable|string|max:20',
            'contact_type' => 'required|string|in:individual,business',
            'primary_contact' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'tax_id_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $customer->update($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->organization_id !== Auth::user()->organization_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}