<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStock extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'shop_stock', 'store_stock', 'damage_stock', 
        'total_stock', 'available_stock', 'Product_id','sold_count','assigned_stock',
    ];
    
    /**
     * Get the Product that owns this stock information
     */
    public function Product(): BelongsTo
    {
        return $this->belongsTo(ProductDetail::class, 'Product_id');
    }
    
    /**
     * Update total and available stock automatically
     */
    public function updateTotals()
    {
        $this->total_stock = $this->shop_stock + $this->store_stock + $this->damage_stock;
        $this->available_stock = $this->shop_stock + $this->store_stock;
        $this->save();
    }
}
