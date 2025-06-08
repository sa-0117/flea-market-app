<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function index(Request $request) {

        $user = auth()->user();
        $key = session('key');

        $productsQuery = $user->favoriteProducts()->with(['listing', 'favoriteBy']);

        if ($key) {
            $productsQuery->where('name', 'like', '%' . $key . '%');
        }

        $products = $productsQuery->paginate(10);

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

        return back(); 
    }

}
