<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(Request $request, Product $product) {
        
        $validated = $request->validated();

        $product->comments()->create([
            'comment' => $validated['comment'], 
            'user_id' => auth::id(),
        ]);

        return back();
    } 
}
