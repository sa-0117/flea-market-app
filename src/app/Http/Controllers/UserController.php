<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{   
    public function show() {
        return view('mypage.mypage');
    }

    public function update() {
        return view('mypage.profile');
    }

    public function edit() {
        return view('purchase.address');
    }
}
