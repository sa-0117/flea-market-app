<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function store(Request $request) {

        //imageがあるかチェック
        if(!$request->hasfile('image')) {
            return redirect('/sell');
        }
        
        //画像保存
        $path = $request->file('image')->store('image', 'public');         

        //商品情報保存
        $item = new Product();
        $item->name = $request->input('name');
        $item->brand = $request->input('brand');
        $item->description = $request->input('description');
        $item->condition = $request->input('condition') ?: '未設定';
        $item->image = $path;
        $item->save();

        //出品情報
        $listing = new Listing();
        $listing->user_id = Auth::id(); 
        $listing->product_id = $item->id;
        $listing->listing_price = preg_replace('/[^\d]/', '', $request->input('listing_price'));
        $listing->status = 'listed';
        $listing->save();

        //カテゴリーの紐づけ
        $item->categories()->sync($request->input('categories', []));
        
        return redirect('/mypage');
    }
}

