<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'model',
        'color',
        'made_by',
        'gender',
        'type',
        'movement',
        'dial_color',
        'strap_color',
        'strap_material',
        'case_diameter_mm',
        'case_thickness_mm',
        'glass_type',
        'water_resistance',
        'features',
        'image',
        'warranty',
        'description',
        'barcode',
        'status',
        'location',
        'brand',
        'category',
        'discription',
        'supplier_id'
    ];

 
    /**
     * Get the supplier of the Product
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(ProductSupplier::class);
    }

    /**
     * Get the price information for the Product
     */
    public function price(): HasOne
    {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    /**
     * Get the stock information for the Product
     */
    public function stock(): HasOne
    {
        return $this->hasOne(ProductStock::class, 'product_id');
    }
}
