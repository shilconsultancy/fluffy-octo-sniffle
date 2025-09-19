<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'sku',
        'description',
        'type',
        'sale_price',
        'purchase_price',
    ];

    /**
     * Get the organization that the item belongs to.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}