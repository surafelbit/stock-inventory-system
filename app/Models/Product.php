<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use BelongsToCompany; // Secure this model to the active company!

    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'description',
        'cost_price',
        'price',
        'stock',
    ];

    // Get the Category this product belongs to
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}