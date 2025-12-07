<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class StockSupplyOrderItem extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'stock_supply_order_items';

    protected $fillable = [
        'stock_supply_order_id',
        'product_id',
        'unit_id',
        'quantity',
        'package_size',
        'unit_cost',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'package_size' => 'decimal:4',
        'unit_cost' => 'decimal:4',
    ];

    public function stockSupplyOrder(): BelongsTo
    {
        return $this->belongsTo(StockSupplyOrder::class, 'stock_supply_order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
