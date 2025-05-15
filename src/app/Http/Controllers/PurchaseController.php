<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function store($item_id) {
        $product = Product::findOrFail($item_id);
        return view('purchase.purchase', compact('product'));
    }
}
