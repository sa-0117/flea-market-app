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

        if ($authUser->id === $listing->user->id) {
            $otherUser = $listing->buyer;
        } else {
            $otherUser = $listing->user;
        }

        $messages = Message::with('user')->where('listing_id', $listing->id)->orderBy('created_at', 'asc')->get();

        return view('transaction', [
            'listing' => $listing,
            'authUser' => $authUser,
            'otherUser' => $otherUser,
            'messages' => $messages,
        ]);
    }


}
