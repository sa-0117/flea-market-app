<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'description',
        'condition'
    ]; 

    public function favoretes()
    {
        return $this->belongsToMany(User::class, 'favorite_products');
    }

    public function listing() {
        
        return $this->hasOne(Listing::class);
    }

    public function orders()
{
    return $this->hasMany(Order::class);
}

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}