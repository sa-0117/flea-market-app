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
        'price',
        'description',
        'condition'
    ]; 

    public function favorete()
    {
        return $this->belongsToMany(User::class, 'favorite_products');
    }

    public function listing() {
        
        return $this->belongsTo(Listing::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}