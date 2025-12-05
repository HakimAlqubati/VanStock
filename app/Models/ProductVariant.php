<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// related models
use App\Models\Product;
use App\Models\AttributeValue;

class ProductVariant extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'product_id',
        'master_sku',
        'barcode',
        'weight',
        'dimensions',
        'status',
        'is_default',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'dimensions' => 'array',
    ];

    public static array $STATUSES = [
        'DRAFT'    => 'draft',
        'ACTIVE'   => 'active',
        'INACTIVE' => 'inactive',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_values', 'variant_id', 'attribute_value_id')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::$STATUSES['ACTIVE']);
    }
}
