<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'active', 'sort_order'];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
