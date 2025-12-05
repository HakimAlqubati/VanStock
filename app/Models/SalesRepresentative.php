<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesRepresentative extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'current_vehicle_id',
        'rep_code',
        'cash_wallet',
        'credit_limit_allowance',
        'commission_rate',
        'last_latitude',
        'last_longitude',
        'last_location_update',
        'is_active',
    ];

    protected $casts = [
        'cash_wallet' => 'decimal:2',
        'credit_limit_allowance' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'last_latitude' => 'decimal:8',
        'last_longitude' => 'decimal:8',
        'last_location_update' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentVehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'current_vehicle_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class);
    }
}
