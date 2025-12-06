<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'active', 'sort_order', 'attribute_set_id'];

    protected $casts = ['active' => 'bool'];

    // public array $translatable = ['name'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function attributeSet()
    {
        return $this->belongsTo(AttributeSet::class);
    }
}
