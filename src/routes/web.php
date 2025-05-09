<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index']);

Route::get('/sell', [SellController::class, 'create']);

Route::get('/mypage', [UserController::class, 'show']);
Route::get('/mypage/profile', [UserController::class, 'update']);



Route::middleware('auth')->group(function(){
    Route::get('/login', [AuthController::class, 'index']);
});
