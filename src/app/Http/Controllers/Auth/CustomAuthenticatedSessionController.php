<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse;

class CustomAuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->route('mylist.index');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。',
        ])->withInput($request->only('email'));
    }

    public function create()
    {
        return view('auth.login');
    }

}








