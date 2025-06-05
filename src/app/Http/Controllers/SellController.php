<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class SellController extends Controller
{
    public function create() {

        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request) {
        
        //画像保存
        $path = $request->file('image')->store('image', 'public');         

        //商品情報保存
        $product = new Product();
        $product->name = $request->input('name');
        $product->brand = $request->input('brand');
        $product->description = $request->input('description');
        $product->condition = $request->input('condition') ?: '未設定';
        $product->image = $path;
        $product->save();

        //出品情報
        $listing = new Listing();
        $listing->user_id = Auth::id(); 
        $listing->product_id = $product->id;
        $listing->listing_price = preg_replace('/[^\d]/', '', $request->input('listing_price'));
        $listing->status = 'listed';
        $listing->save();

        //カテゴリーの紐づけ
        $product->categories()->sync($request->input('categories', []));
        
        return redirect('/mypage');
    }
}

