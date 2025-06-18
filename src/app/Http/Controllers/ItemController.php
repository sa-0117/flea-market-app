<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Listing;

class ItemController extends Controller
{
    public function index(Request $request) {

        $userId = Auth::id();
        $keyword = $request->input('keyword');

        if(!empty($keyword)) {
            session(['key' => $keyword]);
        } else {
            session()->forget('key');
        }

        $query = Listing::with('product')->whereIn('status', ['listed','sold']);

        if($userId !== null) {
            $query->where('user_id', '!=', $userId);
        }

        if (!empty($keyword)) {
            $query->whereHas('product', function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
            });
        }
        
        $listings = $query->get();

        return view('product', compact('listings'));
    }

    public function show($item_id) {

        $listing = Listing::with(['product.favoriteBy', 'product.categories'])->findOrFail($item_id);

        if (auth()->check()) {
            auth()->user()->load('favoriteProducts');
        }
        return view('item', [
            'listing' => $listing,
            'product' => $listing->product,
        ]);
    }
}