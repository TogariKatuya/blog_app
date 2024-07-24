<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use App\Models\ArticleGood;
use Illuminate\Support\Facades\Log;

class BlogInfoController extends Controller
{
    /**
     * 指定されたIDのブログ記事詳細を表示
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $article = Article::with(['user', 'comments.user', 'goods', 'images'])->findOrFail($id);
        return view('user.info', ['blog' => $article]);
    }

    /**
     * 記事にいいねを追加または削除
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, $id)
    {
        Log::debug('User ID:', ['user_id' => Auth::id()]);
        Log::debug('Authenticated:', ['is_authenticated' => Auth::check()]);

        $userId = Auth::id();

        if ($request->ajax()) {
            // 記事が存在するか確認
            $article = Article::findOrFail($id);

            // ユーザーがすでに記事に「いいね」しているか確認
            $existingLike = ArticleGood::where('article_id', $id)->where('user_id', $userId)->first();

            if (!$existingLike) {
                // 新しい「いいね」を作成
                ArticleGood::create([
                    'article_id' => $id,
                    'user_id' => $userId,
                ]);

                // 更新された「いいね」数を取得
                $likeCount = ArticleGood::where('article_id', $id)->count();

                return response()->json(['status' => 'success', 'likeCount' => $likeCount]);
            } else {
                // 「いいね」を削除
                $existingLike->delete();

                // 更新された「いいね」数を取得
                $likeCount = ArticleGood::where('article_id', $id)->count();

                return response()->json(['status' => 'success', 'likeCount' => $likeCount]);
            }
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
