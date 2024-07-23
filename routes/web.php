<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\BlogInfoController;

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
Route::get('/delete', [TopController::class, 'delete'])->name('top.sort');


// ログイン後のみアクセス可
// Route::middleware('auth:user')->group(function () {
//     Route::get('/', function () {
//         return view('user.top');
//     })->name('user.top');
// });

// ブログ詳細ページ
Route::get('/blog/{id}', [BlogInfoController::class, 'show'])->name('blog.info');

// いいね機能
Route::post('/blog/{id}/like', [BlogInfoController::class, 'like'])->name('blog.like');

// コメント機能
Route::post('/blog/{id}/comment', [BlogInfoController::class, 'comment'])->name('blog.comment');

// 登録ルート
Route::post('/registration', [UserLoginController::class, 'registration'])->name('user.login.registration');

// 編集画面表示
Route::get('/blog/{id}/edit', [BlogInfoController::class, 'edit'])->name('blog.edit');

// 編集処理
Route::post('/blog/{id}/update', [BlogInfoController::class, 'update'])->name('blog.update');
