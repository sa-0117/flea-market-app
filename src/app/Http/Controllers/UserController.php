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

        $userName = $request->user()->name;

        if ($page === 'buy') {
            $products = $user->orders()->with('product')->get();
        } else {
            $products = $user->listings()->with('product')->get();
        }

        return view('mypage.mypage',compact('products','page','user','userName'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->post_code = $request->input('post_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');

        // プロフィール更新
        $user->save();

        // ファイルアップロード処理
    if ($request->hasFile('avatar')) {
        $filename = $request->file('avatar')->getClientOriginalName();
        $path = $request->file('avatar')->storeAs('public/image', $filename);
        $user->avatar = $filename;
    }

        // 初回設定時だけ profile_completed を true に
        if (!$user->profile_completed) {
            $user->profile_completed = true;
        }

        $user->save();

        // リダイレクト先を条件で分岐
        if (!$user->wasChanged('profile_completed')) {
            // 編集時 → プロフィール画面
            return redirect('/mypage');
        } else {
            // 初回設定完了 → お気に入りリスト
            return redirect('/mylist');
        }
    } 

    public function edit()
    {
        $user = auth()->user();

        return view('mypage.profile', compact('user'));
    }

    public function store() {
        return view('purchase.address');
    }
}