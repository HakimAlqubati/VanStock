<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerBranch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'email',
        'district_id',
        'address',
        'contact_person',
        'latitude',
        'longitude',
        'is_main',
        'active',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_main' => 'boolean',
        'active' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
