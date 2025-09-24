<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RatingCompletedMail;

class RatingController extends Controller
{
     public function store(Request $request, $listingId) {

        $listing = Listing::with(['user', 'buyer'])->findOrFail($listingId);
        $authUser = auth()->user();

        $rating = Rating::updateOrCreate([
            'listing_id' => $listingId,
            'user_id' => $authUser->id,
        ],[
            'rating' => $request->rating,
            'status' => 'evaluated',
           ]
        );

        if ($authUser->id === $listing->buyer->id) {
            Mail::to($listing->user->email)->send(new RatingCompletedMail($listing));
        }

        return redirect()->route('product.index');
    }
}
