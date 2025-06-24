<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $product) {
        
        $product->comments()->create([
            'comment' => $request->comment, 
            'user_id' => auth()->id(),
        ]);

        return back();
    } 
}
