<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function index(Request $request) {

        $user = auth()->user();
        $key = session('key');

        $productsQuery = $user->favoriteProducts()->with(['listing', 'favoriteBy']);

        $productsQuery = $user->favoriteProducts()->whereHas('listing', function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id);
            })->with(['listing', 'favoriteBy']);

        if ($key) {
            $productsQuery->where('name', 'like', '%' . $key . '%');
        }

        $products = $productsQuery->get();

        return view('mylist', [
            'products'=> $products
        ]);
    }

    public function toggle(Product $product) {
        
        if(!auth()->check()){
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->favoriteProducts()->where('product_id', $product->id)->exists()) {
            $user->favoriteProducts()->detach($product->id);
        } else {
            $user->favoriteProducts()->attach($product->id);
        }

        return redirect()->route('item.show', $product->listing->id); 
    }

}
