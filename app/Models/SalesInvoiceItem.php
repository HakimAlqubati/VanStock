<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesInvoiceItem extends Model
{
    protected $fillable = [
        'sales_invoice_id',
        'product_id',
        'unit_id',
        'package_size',
        'quantity',
        'unit_price',
        'discount',
        'total',
    ];

    protected $casts = [
        'package_size' => 'integer',
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // When a SalesInvoiceItem is created, deduct from inventory
        static::created(function (SalesInvoiceItem $item) {
            $invoice = $item->salesInvoice;

            if (!$invoice) {
                return;
            }

            InventoryTransaction::create([
                'product_id' => $item->product_id,
                'movement_type' => InventoryTransaction::MOVEMENT_OUT,
                'quantity' => $item->quantity,
                'unit_id' => $item->unit_id,
                'package_size' => $item->package_size ?? 1,
                'store_id' => $invoice->store_id,
                'movement_date' => $invoice->invoice_date,
                'transaction_date' => now(),
                'transactionable_id' => $invoice->id,
                'transactionable_type' => SalesInvoice::class,
                'price' => $item->unit_price,
                'notes' => __('lang.sales_invoice') . ': ' . $invoice->invoice_number,
            ]);
        });
    }

    public function salesInvoice(): BelongsTo
    {
        return $this->belongsTo(SalesInvoice::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
