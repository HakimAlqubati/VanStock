<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'plate_number',
        'model',
        'chassis_number',
        'status',
        'max_load_capacity_kg',
        'license_expiry_date',
        'insurance_expiry_date',
    ];

    protected $casts = [
        'license_expiry_date' => 'date',
        'insurance_expiry_date' => 'date',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function salesRepresentative(): HasOne
    {
        return $this->hasOne(SalesRepresentative::class, 'current_vehicle_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class);
    }
}
