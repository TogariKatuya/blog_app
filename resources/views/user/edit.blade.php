<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ブログ編集</title>
    <link rel="stylesheet" href="/css/edit.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>ブログ編集</h1>
            <nav>
                <ul>
                    <li><a href="/user">ホーム</a></li>
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
            <section class="edit-blog">
                <h2>記事を編集する</h2>
                <form action="{{ route('blog.update', $blog->id) }}" method="POST">
                    @csrf
                    <div>
                        <label for="title">タイトル:</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $blog->title) }}"
                            required>
                    </div>
                    <div>
                        <label for="contents">内容:</label>
                        <textarea name="contents" id="contents" required>{{ old('contents', $blog->contents) }}</textarea>
                    </div>
                    <button type="submit">更新する</button>
                </form>
            </section>
        </main>
        <footer>
            <p>&copy; cingroup</p>
        </footer>
    </div>
</body>

</html>
