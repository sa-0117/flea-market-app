<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Listing;

class FavoriteController extends Controller
{
    public function index(Request $request) {

        $user = auth()->user();

        $query = Listing::with('product')->whereIn('status', ['listed','sold']);

        $products = $user->favoriteProducts()->with(['listing', 'favoriteBy'])->paginate(10);

        $listings = $query->get();

        return view('mylist', [
            'products'=> $products, 
            'listings' => $listings
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
