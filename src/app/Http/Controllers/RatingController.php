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

        //評価済みのチェック
        $buyerRated = Rating::where('listing_id', $listingId)
            ->where('user_id', $listing->buyer_id)
            ->where('status', 'evaluated')
            ->exists();

        $sellerRated = Rating::where('listing_id', $listingId)
            ->where('user_id', $listing->user_id)
            ->where('status', 'evaluated')
            ->exists();

        if ($buyerRated && $sellerRated) {
            $listing->update(['status' => 'completed']);
        }

        if ($authUser->id === $listing->buyer->id) {
            Mail::to($listing->user->email)->send(new RatingCompletedMail($listing));
        }

        return redirect()->route('product.index');
    }
}
