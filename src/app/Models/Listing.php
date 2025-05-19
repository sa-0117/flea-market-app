<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'product_id',
        'listing_price',
        'status',
    ]; 

    public function product() {
        
        return $this->belongsTo(Product::class);
    }
}
