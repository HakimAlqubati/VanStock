<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// related models
use App\Models\Category;
use App\Models\Brand;
use App\Models\AttributeSet;
use App\Models\ProductVariant;
use App\Models\ProductSetAttribute;
use App\Models\Attribute;
use App\Models\User;
use App\Models\ProductUnit;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'attribute_set_id',
        'short_description',
        'description',
        'status',
        'is_featured',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public static array $STATUSES = [
        'DRAFT'    => 'draft',
        'ACTIVE'   => 'active',
        'INACTIVE' => 'inactive',
    ];

    protected static function booted(): void
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function attributeSet()
    {
        return $this->belongsTo(AttributeSet::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductSetAttribute::class);
    }

    public function productUnits()
    {
        return $this->hasMany(ProductUnit::class);
    }

    public function attributesDirect()
    {
        return $this->belongsToMany(Attribute::class, 'product_set_attributes')
            ->withPivot(['is_variant_option', 'sort_order'])
            ->withTimestamps();
    }

    public function seAttributes()
    {
        return $this->hasMany(ProductSetAttribute::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes & Helpers
    public function isActive(): bool
    {
        return $this->status === self::$STATUSES['ACTIVE'];
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::$STATUSES['ACTIVE']);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
