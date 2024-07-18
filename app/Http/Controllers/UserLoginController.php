<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserLoginController extends Controller
{
    //
    /**
     * ログイン画面
     */
    public function create(): View
    {
        return view('user.login');
    }

    /**
     * ログイン
     */
    public function store(UserLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('user.top'));
    }

    /**
     * ログアウト
     */
    //     public function destroy(Request $request): RedirectResponse
//     {
//         Auth::guard('user')->logout();
// 
//         $request->session()->invalidate();
// 
//         $request->session()->regenerateToken();
// 
//         return to_route('user.login');
//     }
}