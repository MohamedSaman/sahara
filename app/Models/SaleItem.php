<?php

namespace App\Models;

use App\Models\ProductDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'Product_id',
        'Product_code',
        'Product_name',
        'quantity',
        'unit_price',
        'discount',
        'total',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function Product()
    {
        return $this->belongsTo(ProductDetail::class, 'Product_id');
    }

}
