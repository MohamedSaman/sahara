<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMadeBy extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_name',
    ];
    protected $table = 'Product_made_bies';
}
