<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TopController extends Controller
{
    /**
     * トップページを表示
     *
     * @return \Illuminate\View\View
     */
    public function topdisplay(Request $request)
    {
        $sort = $request->input('sort', 'views'); // デフォルトで観覧数でソート
        $query = $request->input('query', '');

        $blogs = Article::where('delete_flag', false)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%$query%")
                    ->orWhere('contents', 'like', "%$query%");
            })
            ->orderBy($sort, 'desc')
            ->paginate(10);
        Log::debug('User ID:', ['user_id' => Auth::id()]);
        return view('user.top', ['blogs' => $blogs]);
    }
}
