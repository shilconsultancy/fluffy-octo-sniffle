<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'company_name',
        'address',
        'phone',
        'email',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('organization', function (Builder $builder) {
            $builder->where('organization_id', auth()->user()->organization_id);
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}