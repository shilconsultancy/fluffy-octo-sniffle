<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $organization = $user->organization;

        // **FIX:** If the user has no organization, create one.
        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->organization_id = $organization->id;
            $user->save();
            $user->refresh();
            $organization = $user->organization;
        }

        $items = $organization->items()->paginate(10);
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization;

        // **FIX:** If the user has no organization, create one.
        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->organization_id = $organization->id;
            $user->save();
            $user->refresh();
            $organization = $user->organization;
        }
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('items')->where(function ($query) use ($organization) {
                return $query->where('organization_id', $organization->id);
            })],
            'description' => 'nullable|string',
            'type' => 'required|string|in:product,service',
            'sale_price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
        ]);

        $organization->items()->create($validatedData);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        if ($item->organization_id !== Auth::user()->organization_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        if ($item->organization_id !== Auth::user()->organization_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $organization = Auth::user()->organization;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('items')->where(function ($query) use ($organization) {
                return $query->where('organization_id', $organization->id);
            })->ignore($item->id)],
            'description' => 'nullable|string',
            'type' => 'required|string|in:product,service',
            'sale_price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
        ]);

        $item->update($validatedData);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if ($item->organization_id !== Auth::user()->organization_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}