<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;

// ログイン画面
Route::get('/user-login', [UserLoginController::class, 'create'])->name('user.login');
// ログイン
Route::post('/user-login', [UserLoginController::class, 'store'])->name('user.login.store');
// ログアウト
Route::delete('/user-login', [UserLoginController::class, 'destroy'])->name('user.login.destroy');

// ログイン後のみアクセス可
Route::middleware('auth:user')->group(function () {
    Route::get('/user', function () {
        return view('user.top');
    })->name('user.top');
});

Route::post('/registration', [UserLoginController::class, 'registration'])->name('user.login.registration');
Route::get('/user-login', function () {
    return view('user.login');
})->name('user.login');