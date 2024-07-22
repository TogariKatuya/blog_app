<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ブログアプリ</title>
    <link rel="stylesheet" href="css/top.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>ブログアプリ</h1>
            <nav>
                <ul>
                    <li><a href="/create">Blog</a></li>
                    <li><a href="/search">検索</a></li>
                    <li>
                        <form action="/logout" method="POST" style="display: inline;">
                            @csrf
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
                                <a href="/view/{{ $blog->id }}">詳細</a>
                                <a href="/edit/{{ $blog->id }}">編集</a>
                                <a href="/delete/{{ $blog->id }}">削除</a>
                            </div>
                            <p>観覧数: {{ $blog->views }}</p>
                        </article>
                    @endforeach
                @else
                    <p>ブログ記事はありません。</p>
                @endif
            </section>
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
