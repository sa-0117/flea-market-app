<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'listing_id',
        'purchase_price',
        'shopping_post_code',
        'shopping_address',
        'shopping_building'
    ]; 

    public function buyer(){

        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function listing() {
        return $this->belongsTo(Listing::class);
        
    }
}
