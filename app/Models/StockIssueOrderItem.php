<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class StockIssueOrderItem extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'stock_issue_order_items';

    protected $fillable = [
        'stock_issue_order_id',
        'product_id',
        'unit_id',
        'quantity',
        'package_size',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'package_size' => 'decimal:4',
    ];

    public function stockIssueOrder(): BelongsTo
    {
        return $this->belongsTo(StockIssueOrder::class, 'stock_issue_order_id');
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
