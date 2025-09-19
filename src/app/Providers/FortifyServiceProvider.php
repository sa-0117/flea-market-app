<?php

namespace App\Providers;

use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Http\Responses\RegisterResponse as CustomRegisterResponse;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use App\Http\Controllers\Auth\CustomRegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\Laravel\Fortify\Contracts\RegisterResponse::class, \App\Http\Responses\RegisterResponse::class);
        $this->app->singleton(LoginResponseContract::class, CustomLoginResponse::class);
    }

    public function boot(): void
{
    Fortify::ignoreRoutes();

    Route::middleware('web')->group(function () {
        Route::get('/register', [CustomRegisteredUserController::class, 'create'])->name('register');
        Route::post('/register', [CustomRegisteredUserController::class, 'store']);

        Route::get('/login', [CustomAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [CustomAuthenticatedSessionController::class, 'store']);
    });
}


}