<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payment_number',
        'customer_id',
        'payable_type',
        'payable_id',
        'payer_type',
        'payer_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the payable model (SalesInvoice, SalesOrder, etc.)
     * الحصول على السند المرتبط (فاتورة مبيعات، أمر بيع، إلخ)
     */
    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the payer model (SalesRepresentative, User, etc.)
     * الحصول على الدافع (مندوب مبيعات، مستخدم، إلخ)
     */
    public function payer(): MorphTo
    {
        return $this->morphTo();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
