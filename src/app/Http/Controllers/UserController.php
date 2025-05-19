<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{   
    public function show(Request $request) {
        
        $page = $request->query('page','sell');

        $user = auth()->user();

        if ($page === 'buy') {
            $products = $user->orders()->with('product')->get();
        } else {
            $products = $user->listings()->with('product')->get();
        }

        return view('mypage.mypage',compact('products','page'));
    }

    public function update() {
        return view('mypage.profile');
    }

    public function edit() {
        return view('purchase.address');
    }
}
