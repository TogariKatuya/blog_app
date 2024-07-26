<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use App\Models\ArticleGood;
use Illuminate\Support\Facades\Log;
use League\CommonMark\CommonMarkConverter;

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
        // ビュー数を増加
        $article->increment('views');
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
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'contents' => 'required|string',
        ]);

        // 記事を取得
        $article = Article::findOrFail($id);
        $userId = Auth::id();

        // 認証ユーザーが記事の著者であるか確認
        if ($article->user_id !== $userId) {
            return redirect()->route('blog.info', ['id' => $id])->with('error', '更新する権限がありません。');
        }

        // 記事の更新
        $article->update([
            'title' => $request->input('title'),
            'contents' => $request->input('contents'),
        ]);

        return redirect()->route('blog.info', ['id' => $id])->with('status', '記事が更新されました！');
    }


    /**
     * 記事を削除
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        // ユーザー認証
        $userId = Auth::id();

        // 記事を取得
        $article = Article::where('id', $id)
            ->where('user_id', $userId) // 自分の投稿のみ削除可能
            ->firstOrFail();

        // 論理削除フラグを設定
        $article->update([
            'delete_flag' => 1,
        ]);

        return redirect()->route('top.topdisplay')->with('status', '記事が削除されました！');
    }

    // ブログ作成画面を表示
    public function create()
    {
        return view('user.create');
    }

    // ブログ保存処理
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'contents' => 'required|string',
        ]);

        // マークダウンをHTMLに変換
        $converter = new CommonMarkConverter();
        $htmlContents = $converter->convertToHtml($request->input('contents'));

        // 記事の作成
        $article = new Article([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'contents' => $request->input('contents'),
            'hash' => substr(md5(uniqid(rand(), true)), 0, 16),
            'port_stauts_flag' => 1, // 公開状態の初期値
            'delete_flag' => 0, // 未削除の状態
            'views' => 0, // 初期観覧数
        ]);

        // 記事の保存
        $article->save();

        // 作成完了後のリダイレクト
        return redirect()->route('top.topdisplay', $article->id)
            ->with(['success' => 'ブログ記事を作成しました！', 'clearDraft' => true]);
    }
    public function likeStatus(Request $request, $id)
    {
        $userId = Auth::id();
        $liked = ArticleGood::where('article_id', $id)->where('user_id', $userId)->exists();

        return response()->json(['liked' => $liked]);
    }
}

