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

    public function favoriteBy()
    {
        return $this->belongsToMany(User::class, 'favorite_products', 'product_id', 'user_id')->withTimestamps();
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favoriteBy()->where('user_id', $user->id)->exists();
    }

    public function listing() {
        
        return $this->hasOne(Listing::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}