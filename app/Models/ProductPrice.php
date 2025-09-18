<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPrice extends Model
{
    use HasFactory;
    
    protected $fillable = ['supplier_price', 'selling_price', 'discount_price', 'Product_id'];
    
    /**
     * Get the Product that owns this price information
     */
    public function Product(): BelongsTo
    {
        return $this->belongsTo(ProductDetail::class, 'Product_id');
    }
    
    /**
     * Calculate the profit margin percentage
     */
    public function getProfitMarginAttribute()
    {
        if ($this->supplier_price > 0) {
            $price = $this->discount_price ?? $this->selling_price;
            return (($price - $this->supplier_price) / $this->supplier_price) * 100;
        }
        return 0;
    }
}
