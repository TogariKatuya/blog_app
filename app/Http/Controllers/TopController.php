<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

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

        $blogs = Article::where('title', 'like', "%$query%")
            ->orWhere('contents', 'like', "%$query%")
            ->orderBy($sort, 'desc')
            ->paginate(10);

        return view('user.top', ['blogs' => $blogs]);
    }
}
