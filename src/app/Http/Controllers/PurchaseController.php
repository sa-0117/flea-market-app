<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Listing;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function show(Request $request, $item_id) {

        if(!auth()->check()){
            return redirect()->route('login');
        }

        $listing = Listing::with('Product')->findOrFail($item_id);

        $payment = $request->query('payment');

        $user = auth()->user();

        return view('purchase.purchase', [
            'listing' => $listing,
            'user' => $user,
            'payment' => $request->input('payment')
        ]);
    }

    public function store(PurchaseRequest $request, $item_id) {

        $listing = Listing::with('product')->findOrFail($item_id);
        $user = auth()->user();
        $validated = $request->validated();

        //購入済みかチェック
        if ($listing->buyer_id) {
            return back();
        }

        //購入処理
        $listing->buyer_id = $user->id;
        $listing->save();

        $user->orders()->create([
     
            'listing_id' => $listing->id,
            'purchase_price' => $listing->listing_price,
            'shopping_post_code' => $validated['post_code'], 
            'shopping_address' => $validated['address'], 
            ]);  

        return  redirect('/mypage?page=buy')->with('status', '購入が完了しました。');
    }
}
