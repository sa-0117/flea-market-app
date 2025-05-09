<?php

namespace App\Http\Controllers;

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

        return view('product_index', compact('products'));
    }





}
