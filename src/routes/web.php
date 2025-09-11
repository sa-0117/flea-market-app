<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::get('/', [ItemController::class, 'index'])->name('product.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

Route::middleware(['auth', 'verified'])->group(function (){
    Route::post('/item/{product}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/mylist',[FavoriteController::class, 'index'])->name('mylist.index');
    Route::post('/favorite/{product}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
    Route::get('/sell', [SellController::class, 'create']);
    Route::post('/sell', [SellController::class, 'store']);
    Route::get('/mypage', [UserController::class, 'show']);
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::post('/mypage/profile', [UserController::class, 'update']); 
    Route::get('/purchase/address/{item_id}', [UserController::class, 'editFromPurchase'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [UserController::class, 'updateFromPurchase'])->name('purchase.address.update');
    Route::get('/purchase/{item_id}',[PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item_id}/pay', [PurchaseController::class, 'pay'])->name('purchase.pay');
    Route::get('/purchase/{item_id}/success', [PurchaseController::class, 'success'])->name('purchase.success');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/mypage/profile'); 
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');

    Route::get('/email/verify/check', function () {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect('/mypage/profile'); 
        }
        return back();  
    })->name('verification.check');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


