<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Listing;

class ItemController extends Controller
{
    public function index() {

        $userId = Auth::id();

        $query = Listing::with('product')->whereIn('status', ['listed','sold']);

        if($userId !== null) {
            $query->where('user_id', '!=', $userId);
        }

        $listings = $query->get();

        return view('product', compact('listings'));
    }

    public function show($item_id) {
        $listing = Listing::with('product')->findOrFail($item_id);
        return view('item', compact('listing'));
    }





}
