<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Listing;
use App\Models\Message;

class TransactionController extends Controller
{
    public function show($listingId) {

        $listing = Listing::with(['product', 'user', 'buyer'])->findOrFail($listingId);
        $authUser = auth()->user();

        //商品の未読→既読へ
        Message::where('listing_id', $listing->id)
            ->where('user_id', '!=', $authUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $otherUser = $authUser->id === $listing->user->id ? $listing->buyer : $listing->user;

        $messages = Message::with('user')->where('listing_id', $listing->id)->orderBy('created_at', 'asc')->get();

        $myRating = $listing->ratings->firstWhere('user_id', $authUser->id);
        $otherRating = $listing->ratings->firstWhere('user_id', $otherUser->id);

        $sellerModal = false;

        if ($authUser->id === $listing->user_id && $otherRating && $otherRating->status === 'evaluated' 
            && (!$myRating || $myRating->status === 'waiting')) {
            $sellerModal = true;
        }

        $buyerButton = $authUser->id === $listing->buyer_id && (!$myRating || $myRating->status === 'waiting');

        //その他の取引一覧
        $listings = Listing::with('product')
        ->where(function($q) use ($authUser){
            $q->where('user_id', $authUser->id)
            ->orWhere('buyer_id', $authUser->id);
        })
        ->whereNotNull('buyer_id')
        ->where('id', '!=', $listing->id)
        ->where('status', '!=', 'completed')
        ->get();

        $isSeller = $authUser->id === $listing->user_id; 

        return view('transaction', compact(
            'listing',
            'authUser',
            'otherUser',
            'messages',
            'buyerButton',
            'sellerModal',
            'listings',
            'isSeller'
        ));
    }

}
