<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Listing;
use App\Models\Message;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{   
    public function show(Request $request) {

        $tab = $request->query('tab','sell');

        $user = auth()->user();

        $averageRating = round($user->ratings()->avg('rating'));

        $listings = collect();
        $orders = collect();

        if ($tab === 'sell') {
            $listings = Listing::with('product')->where('user_id', $user->id)->get();
        } elseif ($tab === 'buy') {
            $orders = $user->orders()->with('listing.product')->latest()->get();
        } elseif ($tab === 'transaction') {
            $listings = Listing::with(['product', 'messages'])
            ->withMax('messages', 'created_at') //最新メッセージ取得
            ->where(function ($query) use ($user){
                $query->where('user_id', $user->id)
                    ->orWhere('buyer_id', $user->id);
            })
            ->where('status', 'Sold')
            ->orderByDesc('messages_max_created_at') //最新メッセージ順に並び替え
            ->get();

            //未読→既読へupdate
            Message::whereIn('listing_id', $listings->pluck('id'))
                ->where('user_id', '!=', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $listings->map(function($listing) use ($user) {
                $listing->newMessageCount = $listing->messages
                    ->where('user_id', '!=', $user->id)
                    ->where('is_read', false)
                    ->count();
                return $listing;
            });
        }

        $transactionListings = Listing::with('product', 'messages')->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('buyer_id', $user->id);
            })
            ->where('status', 'Sold')
            ->get();

        $newMessageCount = Message::whereIn('listing_id', $transactionListings->pluck('id'))
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->count();

        $transactionListings->map(function($listing) use ($user) {
            $listing->newMessageCount = $listing->messages
                ->where('user_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();

            return $listing;
        });

        return view('mypage.mypage',[
            
            'listings' => $listings,
            'tab' => $tab,
            'user' => $user,
            'orders' => $orders,
            'averageRating' => $averageRating,
            'transactionListings' => $transactionListings,
            'newMessageCount' => $newMessageCount,
        ]);
        
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

         // 初回プロフィール設定かつメール未認証ならブロック
        if (!$user->profile_completed && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        $validated = $request->validated();

        $user->name = $validated['name'] ?? $user->name;
        $user->post_code = $validated['post_code'] ?? $user->post_code;
        $user->address = $validated['address'] ?? $user->address;
        $user->building = $request->input('building');
        $user->save();

    if ($request->hasFile('avatar')) {
        $filename = $request->file('avatar')->getClientOriginalName();
        $path = $request->file('avatar')->storeAs('public/image', $filename);
        $user->avatar = $filename;
    }

        // 初回設定時だけ profile_completed を true に
        if (!$user->profile_completed) {
            $user->profile_completed = true;
        }

        $user->save();

        if (!$user->wasChanged('profile_completed')) {
            // 編集時 → プロフィール画面
            return redirect('/mypage');
        } else {
            // 初回設定完了 → お気に入りリスト
            return redirect('/mylist');
        }
    } 

    public function edit()
    {
        $user = auth()->user();
        return view('mypage.profile', compact('user'));
    }

    public function editFromPurchase($item_id) {   

        $user = auth()->user();
        return view('purchase.address', compact('user', 'item_id'));
    }

    public function updateFrompurchase(AddressRequest $request, $item_id) {

        $user = auth()->user();
        $user->post_code = $request->input('post_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');
        $user->save();

        return redirect()->route('purchase.show', ['item_id' => $item_id]);
    }
}