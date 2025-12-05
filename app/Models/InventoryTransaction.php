<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class InventoryTransaction extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'inventory_transactions';

    protected $fillable = [
        'product_id', 'movement_type', 'quantity', 'unit_id',
        'movement_date', 'notes', 'package_size', 'store_id',
        'price', 'transaction_date', 'purchase_invoice_id',
        'transactionable_id', 'transactionable_type',
        'waste_stock_percentage', 'source_transaction_id',
        'remaining_quantity', 'base_unit_id', 'base_quantity',
        'base_unit_package_size', 'price_per_base_unit',
    ];

    const MOVEMENT_OUT = 'out';
    const MOVEMENT_IN = 'in';

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function sourceTransaction()
    {
        return $this->belongsTo(InventoryTransaction::class, 'source_transaction_id');
    }

    public function baseUnit()
    {
        return $this->belongsTo(Unit::class, 'base_unit_id');
    }
}