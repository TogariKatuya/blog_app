<?php

use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\BlogInfoController;
use Illuminate\Support\Facades\Route;

// ログイン関連のルート
// Route::middleware(['guest'])->group(function () {
// ログイン画面
Route::get('/user-login', [UserLoginController::class, 'create'])->name('user.login');
// ログイン
Route::post('/user-login', [UserLoginController::class, 'store'])->name('user.login.store');
// ユーザー登録
Route::post('/registration', [UserLoginController::class, 'registration'])->name('user.login.registration');
// });

// ログイン後のみアクセス可
Route::middleware(['auth'])->group(function () {
    // ログアウト
    Route::delete('/user-login', [UserLoginController::class, 'destroy'])->name('user.login.destroy');

    // トップページのルート
    Route::get('/user', [TopController::class, 'topdisplay'])->name('top.topdisplay');
    Route::get('/search', [TopController::class, 'topdisplay'])->name('top.search');
    Route::get('/sort', [TopController::class, 'topdisplay'])->name('top.sort');
    Route::get('/delete', [TopController::class, 'delete'])->name('top.delete');

    // ブログ詳細ページ
    Route::get('/blog/{id}', [BlogInfoController::class, 'show'])->name('blog.info');

    // いいね機能
    Route::post('/blog/{id}/like', [BlogInfoController::class, 'like'])->name('blog.like');
    // ルート
    Route::get('/blog/{id}/like-status', [BlogInfoController::class, 'likeStatus']);

    // コメント機能
    Route::post('/blog/{id}/comment', [BlogInfoController::class, 'comment'])->name('blog.comment');

    // 編集画面表示
    Route::get('/blog/{id}/edit', [BlogInfoController::class, 'edit'])->name('blog.edit');

    // 編集処理
    Route::post('/blog/{id}/update', [BlogInfoController::class, 'update'])->name('blog.update');

    // 削除処理
    Route::delete('/blog/{id}/delete', [BlogInfoController::class, 'delete'])->name('blog.delete');

    // ブログ作成画面
    Route::get('/create', [BlogInfoController::class, 'create'])->name('user.create');

    // ブログ保存処理
    Route::post('/blog', [BlogInfoController::class, 'store'])->name('user.blog.store');
});

