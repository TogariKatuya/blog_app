<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\TopController;

// ログイン画面
Route::get('/user-login', [UserLoginController::class, 'create'])->name('user.login');
// ログイン
Route::post('/user-login', [UserLoginController::class, 'store'])->name('user.login.store');
// ログアウト
Route::delete('/user-login', [UserLoginController::class, 'destroy'])->name('user.login.destroy');


// トップページのルート
Route::get('/user', [TopController::class, 'topdisplay'])->name('top.topdisplay');
Route::get('/search', [TopController::class, 'topdisplay'])->name('top.search');
Route::get('/sort', [TopController::class, 'topdisplay'])->name('top.sort');

// ログイン後のみアクセス可
Route::middleware('auth:user')->group(function () {
    Route::get('/', function () {
        return view('user.top');
    })->name('user.top');
});

// 登録ルート
Route::post('/registration', [UserLoginController::class, 'registration'])->name('user.login.registration');