<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index()
    {
        $user = Auth::user();
        $organization = $user->organization;

        // Create a default organization if one doesn't exist for the user
        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->update(['organization_id' => $organization->id]);
            $user->refresh();
            $organization = $user->organization;
        }

        $invoices = $organization->invoices()->with('customer')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $user = Auth::user();
        $organization = $user->organization;

        // Create a default organization if one doesn't exist for the user
        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->update(['organization_id' => $organization->id]);
            $user->refresh();
            $organization = $user->organization;
        }
        
        $customers = $organization->customers()->get();
        return view('invoices.create', compact('customers'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.item_description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
        ]);

        $organization = Auth::user()->organization;

        DB::transaction(function () use ($validatedData, $organization) {
            $subtotal = collect($validatedData['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });

            $invoiceNumber = 'INV-' . now()->format('YmdHis');

            $invoice = $organization->invoices()->create([
                'customer_id' => $validatedData['customer_id'],
                'invoice_number' => $invoiceNumber,
                'invoice_date' => $validatedData['invoice_date'],
                'due_date' => $validatedData['due_date'],
                'subtotal' => $subtotal,
                'total_amount' => $subtotal,
                'status' => 'Draft',
            ]);

            foreach ($validatedData['items'] as $item) {
                $invoice->items()->create([
                    'item_description' => $item['item_description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ]);
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully!');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        if ($invoice->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }

        $invoice->load('customer', 'items');
        return view('invoices.show', compact('invoice'));
    }
}