<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the users associated with the organization.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the settings for the organization.
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }
    
    /**
     * Get the items for the organization.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
    
    /**
     * Get the customers for the organization.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the quotes for the organization.
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Get the invoices for the organization.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the payments received for the organization.
     */
    public function paymentsReceived(): HasMany
    {
        return $this->hasMany(PaymentReceived::class);
    }
}