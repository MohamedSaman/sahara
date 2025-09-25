<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;

class StaffProduct extends Model
{
    // Specify the table if it does not follow Laravel conventions
    protected $table = 'staff_products';

    // Fillable fields for mass assignment
    protected $fillable = [
        'Product_id',     // foreign key to Product_details
        'staff_id',
        'quantity',
        'price',
        // add other fields here
    ];

    /**
     * Relationship: StaffProduct belongs to one ProductDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ProductDetail()
    {
        // 'Product_id' is the foreign key in staff_products table
        // pointing to the 'id' of the Product_details table
        return $this->belongsTo(ProductDetail::class, 'Product_id');
    }
    public function Product()
{
    return $this->belongsTo(ProductDetail::class, 'Product_id');
}
    public function staffSale()
    {
        return $this->belongsTo(StaffSale::class, 'staff_id');
    }

    /**
     * Get the total price for the product
     *
     * @return float
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }   
}
