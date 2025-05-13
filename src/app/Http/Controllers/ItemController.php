<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;

class ItemController extends Controller
{
    public function index() {

        $page = request()->query('page');

        if ($page === 'mylist') {
  
            $products = Auth::user()->favorites()->with('product')->get();
        } else {
            
            $products = Product::latest()->get();
        }

        return view('product', compact('products'));
    }

    public function show($item_id) {
        $product = Product::findOrFail($item_id);
        return view('item', compact('product'));
    }





}
