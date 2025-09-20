<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    // ... index, create, store methods are correct ...

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

        $quotes = $organization->quotes()->with('customer')->latest()->paginate(10);
        return view('quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $organization = $user->organization;

        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->update(['organization_id' => $organization->id]);
            $user->refresh();
            $organization = $user->organization;
        }

        $customers = $organization->customers()->orderBy('name')->get();
        $items = $organization->items()->orderBy('name')->get();
        return view('quotes.create', compact('customers', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quote_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:quote_date',
            'quote_items' => 'required|array|min:1',
            'quote_items.*.item_id' => 'required|exists:items,id',
            'quote_items.*.quantity' => 'required|numeric|min:1',
            'quote_items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $organization = Auth::user()->organization;

        DB::transaction(function () use ($request, $organization) {
            $quote = $organization->quotes()->create([
                'customer_id' => $request->customer_id,
                'quote_number' => $this->generateQuoteNumber($organization),
                'quote_date' => $request->quote_date,
                'expiry_date' => $request->expiry_date,
                'status' => 'draft',
                'notes' => $request->notes,
                'terms' => $request->terms,
                'subtotal' => 0, 'tax_total' => 0, 'total' => 0,
            ]);

            $subtotal = 0;
            foreach ($request->quote_items as $itemData) {
                $item = Item::find($itemData['item_id']);
                $lineTotal = $itemData['quantity'] * $itemData['unit_price'];
                $subtotal += $lineTotal;

                $quote->items()->create([
                    'item_id' => $item->id,
                    'description' => $item->description ?? $item->name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $lineTotal,
                ]);
            }

            $taxTotal = $subtotal * 0;
            $total = $subtotal + $taxTotal;

            $quote->update(['subtotal' => $subtotal, 'tax_total' => $taxTotal, 'total' => $total]);
        });

        return redirect()->route('quotes.index')->with('success', 'Quote created successfully.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        if ($quote->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show a print-friendly version of the specified resource.
     */
    public function print(Quote $quote)
    {
        if ($quote->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }
        return view('quotes.print', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        if ($quote->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }
        
        $organization = Auth::user()->organization;
        $customers = $organization->customers()->orderBy('name')->get();
        $items = $organization->items()->orderBy('name')->get();
        
        // Eager load the items relationship to prevent extra queries in the view
        $quote->load('items');

        return view('quotes.edit', compact('quote', 'customers', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        if ($quote->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quote_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:quote_date',
            'quote_items' => 'required|array|min:1',
            'quote_items.*.item_id' => 'required|exists:items,id',
            'quote_items.*.quantity' => 'required|numeric|min:1',
            'quote_items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $quote) {
            $quote->update([
                'customer_id' => $request->customer_id,
                'quote_date' => $request->quote_date,
                'expiry_date' => $request->expiry_date,
                'notes' => $request->notes,
                'terms' => $request->terms,
            ]);

            // Delete old items and add new ones
            $quote->items()->delete();

            $subtotal = 0;
            foreach ($request->quote_items as $itemData) {
                $item = Item::find($itemData['item_id']);
                $lineTotal = $itemData['quantity'] * $itemData['unit_price'];
                $subtotal += $lineTotal;

                $quote->items()->create([
                    'item_id' => $item->id,
                    'description' => $item->description ?? $item->name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $lineTotal,
                ]);
            }

            $taxTotal = $subtotal * 0;
            $total = $subtotal + $taxTotal;

            $quote->update(['subtotal' => $subtotal, 'tax_total' => $taxTotal, 'total' => $total]);
        });

        return redirect()->route('quotes.index')->with('success', 'Quote updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        if ($quote->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }
        
        $quote->delete();
        return redirect()->route('quotes.index')->with('success', 'Quote deleted successfully.');
    }

    /**
     * Helper function to generate a unique quote number.
     */
    private function generateQuoteNumber($organization)
    {
        $lastQuote = $organization->quotes()->latest('id')->first();
        $nextNumber = $lastQuote ? (int)substr($lastQuote->quote_number, -4) + 1 : 1;
        return 'QT-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}