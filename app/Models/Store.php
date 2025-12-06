<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Store extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'location',
        'active',
        'default_store',
        'storekeeper_id',
    ];

    protected $appends = ['storekeeper_name'];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeDefaultStore($query)
    {
        return $query->where('default_store', true)->active()->first();
    }

    public function storekeeper()
    {
        return $this->belongsTo(User::class, 'storekeeper_id');
    }

    public function vehicle(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Vehicle::class);
    }

    public function getStorekeeperNameAttribute()
    {
        return $this->storekeeper?->name;
    }
}
