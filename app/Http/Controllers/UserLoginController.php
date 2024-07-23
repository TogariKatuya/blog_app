<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Log; // Logファサードを追加

class UserLoginController extends Controller
{
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

        return redirect()->intended(route('top.topdisplay'));
    }

    /**
     * ログアウト
     */
    public function destroy(Request $request): RedirectResponse
    {
        dd($request);
        Auth::guard('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('user.login');
    }

    /**
     * ユーザー登録
     */
    public function registration(Request $request)
    {
        // デバッグ用ログ
        Log::debug('Registration method called');

        $request->validate([
            'popupName' => 'required|string|max:255',
            'popupPassword' => 'required|string|max:20',
            'popupEmail' => 'required|string|email|max:255|unique:users,email',
        ]);

        try {
            // デバッグ用ログ
            Log::debug('Validation passed');

            $user = User::create([
                'first_name' => $request->popupName,
                'password' => bcrypt($request->popupPassword),
                'email' => $request->popupEmail,
                'delete_flag' => false,
            ]);

            // デバッグ用ログ
            Log::debug('User created', ['user' => $user]);

            return response()->json(['message' => '新しいユーザーが作成されました', 'user' => $user], 201);
        } catch (\Exception $e) {
            // エラーログ
            Log::error('ユーザー作成に失敗しました', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'ユーザー作成に失敗しました', 'error' => $e->getMessage()], 500);
        }
    }
}
