<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $customers = Customer::all();
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

        DB::transaction(function () use ($validatedData) {
            $subtotal = collect($validatedData['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });

            $invoiceNumber = 'INV-' . now()->format('YmdHis');

            $invoice = Invoice::create([
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
        $invoice->load('customer', 'items');
        return view('invoices.show', compact('invoice'));
    }
}