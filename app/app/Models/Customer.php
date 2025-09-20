<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- ADD THIS

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'phone',
        'contact_type',
        'primary_contact',
        'billing_address',
        'shipping_address',
        'tax_id_number',
        'notes',
    ];

    /**
     * Get the organization that the customer belongs to.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    
    /**
     * Get the quotes for the customer.
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}