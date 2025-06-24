<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'buyer_id',
        'product_id',
        'listing_price',
        'status',
    ]; 

    public function order() {
        return $this->hasOne(Order::class);
    }

    public function buyer(){

        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function product() {
        
        return $this->belongsTo(Product::class);
    }
}
