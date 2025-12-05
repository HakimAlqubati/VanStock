<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class ProductSetAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_set_attributes';

    protected $fillable = ['product_id', 'attribute_id', 'is_variant_option', 'sort_order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
