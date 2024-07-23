<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class BlogInfoController extends Controller
{
    /**
     * 指定されたIDのブログ記事詳細を表示
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // 記事と関連するユーザー、コメント、いいね、画像を取得
        $article = Article::with(['user', 'comments.user', 'goods', 'images'])->findOrFail($id);

        return view('user.info', ['blog' => $article]);
    }

    /**
     * 記事にいいねを追加
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like(Request $request, $id)
    {
        dd($request, $id);
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'ログインが必要です。']);
        }

        $article = Article::findOrFail($id);
        $userId = Auth::id();

        if ($request->ajax()) {
            // ユーザーがすでに記事に「いいね」しているか確認
            if (!$article->goods()->where('user_id', $userId)->exists()) {
                // 新しい「いいね」を作成
                $article->goods()->create(['user_id' => $userId]);

                // 更新された「いいね」数を取得
                $likeCount = $article->goods->count();

                return response()->json(['status' => 'success', 'message' => '記事に「いいね」しました！', 'likeCount' => $likeCount]);
            }

            return response()->json(['status' => 'error', 'message' => 'この記事にはすでに「いいね」しています。']);
        }

        return redirect()->route('blog.info', ['id' => $id]);
    }


    /**
     * 記事にコメントを追加
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $article = Article::findOrFail($id);
        $userId = Auth::id();

        $article->comments()->create([
            'user_id' => $userId,
            'body' => $request->input('comment'),
        ]);

        return redirect()->route('blog.info', ['id' => $id]);
    }

    /**
     * 記事の編集画面を表示
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('user.edit', ['blog' => $article]);
    }

    /**
     * 記事を更新
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'contents' => 'required|string',
        ]);

        $article = Article::findOrFail($id);

        $article->update([
            'title' => $request->input('title'),
            'contents' => $request->input('contents'),
        ]);

        return redirect()->route('blog.info', ['id' => $id])->with('status', '記事が更新されました！');
    }
}
