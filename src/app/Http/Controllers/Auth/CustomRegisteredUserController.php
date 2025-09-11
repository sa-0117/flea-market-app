<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Contracts\RegisterResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class CustomRegisteredUserController extends Controller
{
    public function store(\App\Http\Requests\RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        auth()->login($user);

        event(new Registered($user));

        return redirect()->route('verification.notice');
    }

    public function create()
    {
        return view('auth.register');
    }

}

