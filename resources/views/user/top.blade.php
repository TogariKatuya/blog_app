<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ブログアプリ</title>
    <link rel="stylesheet" href="css/top.css">
    <script src="js/create.js"></script>
</head>

<body>
    <div class="container">
        <header>
            <h1>ブログアプリ</h1>
            <nav>
                <ul>
                    <li><a href="/create">Blog UP</a></li>
                    <li>
                        <form action="{{ route('user.login.destroy') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <section class="search">
                <form action="/search" method="GET">
                    <input type="text" name="query" placeholder="検索...">
                    <button type="submit">検索</button>
                </form>
            </section>
            <section class="sort">
                <form action="/sort" method="GET">
                    <label for="sort">ソート:</label>
                    <select name="sort" id="sort">
                        <option value="views">観覧数</option>
                        <!-- 他のソートオプションを追加 -->
                    </select>
                    <button type="submit">ソート</button>
                </form>
            </section>
            <section class="blog-list">
                @if ($blogs->count())
                    @foreach ($blogs as $blog)
                        <article class="blog-item">
                            <h2>{{ $blog->title }}</h2>
                            <p>{{ Str::limit($blog->contents, 100) }}</p>
                            <div class="actions">
                                <a href="/blog/{{ $blog->id }}">詳細</a>
                                @if (Auth::id() === $blog->user_id)
                                    <a href="/blog/{{ $blog->id }}/edit">編集</a>
                                    <form action="{{ route('blog.delete', ['id' => $blog->id]) }}" method="POST"
                                        style="display: inline;" onsubmit="return confirm('本当にこの記事を削除しますか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">削除</button>
                                    </form>
                                @endif
                            </div>
                            <p>観覧数: {{ $blog->views }}</p>
                        </article>
                    @endforeach
                @else
                    <p>ブログ記事はありません。</p>
                @endif
            </section>
            @if (session('clearDraft'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        clearDraft();
                    });
                </script>
            @endif
            <section class="pagination">
                {{ $blogs->links() }}
            </section>
        </main>
        <footer>
            <p>&copy; cingroup</p>
        </footer>
    </div>
</body>

</html>
