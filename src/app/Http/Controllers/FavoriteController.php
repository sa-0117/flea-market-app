<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index() {

        $user = auth()->user();
        $products = Auth::user()->favorites()->with('category')->get();

        return view('mylist', compact('products'));
    }
}
