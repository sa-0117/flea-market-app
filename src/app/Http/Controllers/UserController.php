<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

    public function update(Request $request)
    {
        $user = Auth::user();

        // プロフィール更新
        $user->fill($validated);

        // ファイルアップロード処理
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

        // 初回設定時だけ profile_completed を true に
        if (!$user->profile_completed) {
            $user->profile_completed = true;
        }

        $user->save();

        // リダイレクト先を条件で分岐
        if (!$user->wasChanged('profile_completed')) {
            // 編集時 → プロフィール画面へ
            return redirect('/mypage');
        } else {
            // 初回設定完了 → お気に入りリストへ
            return redirect('/mylist');
        }
    } 

    public function edit()
{
    $user = Auth::user();
    return view('mypage.profile', compact('user'));
}

    public function store() {
        return view('purchase.address');
    }
}