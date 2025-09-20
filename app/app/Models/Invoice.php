<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'status',
        'subtotal',
        'total_amount',
    ];

    /**
     * An invoice belongs to a customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * An invoice has many line items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}