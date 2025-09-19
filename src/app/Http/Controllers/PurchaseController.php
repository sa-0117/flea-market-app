<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $listing = Listing::with('product')->findOrFail($item_id);

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

        session([
            'post_code' => $validated['post_code'],
            'address' => $validated['address'],
            'building' => $request->building,
        ]);
    

        Stripe::setApiKey(config('stripe_secret_key'));

            $payment_method = $request->input('payment');
            $payment_method_types = $payment_method === 'konbini' ? ['konbini'] : ['card'];

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
                'success_url' => route('purchase.success', ['item_id' => $item_id]),
            ]);

            return redirect($session->url);
    }

    public function success(Request $request, $item_id) {

        $listing = Listing::with('product')->findOrFail($item_id);
        $user = auth()->user();

        if ($listing->buyer_id) {
            return redirect('/');
        }

        $listing->buyer_id = $user->id;
        $listing->status = 'Sold';
        $listing->save();

        $user->orders()->create([
            'listing_id' => $listing->id,
            'purchase_price' => $listing->listing_price,
            'shopping_post_code' => session('post_code'),
            'shopping_address' => session('address'),
            'shopping_building' => session('building'),
        ]);

        // セッションから削除
        session()->forget(['post_code', 'address', 'building']);

        return redirect('/mypage?tab=buy');
    }

}