<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_units'; // Explicit table name

    protected $fillable = [
        'product_id',
        'unit_id',
        'package_size',
        'cost_price',
        'selling_price',
        'stock',
        'moq',
        'is_default',
        'status',
        'sort_order',
        'created_by',
        'updated_by', // [cite: 58]
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'cost_price' => 'decimal:4',
        'selling_price' => 'decimal:4',
        'package_size' => 'integer',
        'stock' => 'integer',
    ];

    public static array $STATUSES = [
        'ACTIVE'   => 'active',
        'INACTIVE' => 'inactive',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getPricePerPiece(): float
    {
        if ($this->package_size <= 0) return 0;
        return round($this->selling_price / $this->package_size, 2);
    }
}
