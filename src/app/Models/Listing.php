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

    public function user(){

        return $this->belongsTo(User::class, 'user_id');
    }

    public function buyer(){

        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function product() {
        
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


}
