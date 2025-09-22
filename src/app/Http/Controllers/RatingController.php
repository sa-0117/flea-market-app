<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
     public function store(Request $reques, $listingId) {

        Rating::create([
        'user_id'   => auth()->id(),
        'listing_id'=> $listingId,
        'rating'    => $request->rating,
    ]);

        return redirect()->route('product.index');
    }
}
