<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Listing;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show(Request $request, $item_id) {

        if(!auth()->check()){
            return redirect()->route('login');
        }

        $listing = Listing::with('Product')->findOrFail($item_id);

        $payment = $request->query('payment');

        $user = auth()->user()->fresh();

        return view('purchase.purchase', [
            'listing' => $listing,
            'user' => $user,
            'payment' => $request->input('payment')
        ]);
    }

    public function pay(PurchaseRequest $request, $item_id) {

        $listing = Listing::with('product')->findOrFail($item_id);
        $user = auth()->user();
        $validated = $request->validated();

        if ($listing->buyer_id) {
            return back();
        }

        $listing->buyer_id = $user->id;
        $listing->status = 'sold';
        $listing->save();

        $user->orders()->create([
            
            'listing_id' => $listing->id,
            'purchase_price' => $listing->listing_price,
            'shopping_post_code' => $validated['post_code'], 
            'shopping_address' => $validated['address']
        ]);  

        if (app()->environment('testing')) {
        // テスト時はStripe処理をスキップして直接リダイレクト
        return redirect('/mypage?page=buy');
    }

        Stripe::setApiKey(config('services.stripe.secret'));

        $payment_method = $request->input('payment');
        $payment_method_types = $payment_method ==='konbini' ?['konbini'] : ['card'];

        $session = Session::create([
            'payment_method_types' => $payment_method_types,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $listing->product->name,                         
                    ],
                    'unit_amount' => $listing->listing_price, 
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/mypage?page=buy'),
        ]);

        return  redirect($session->url);
    }
}
