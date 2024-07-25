<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ブログ作成</title>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <script src="{{ asset('js/create.js') }}" defer></script>
</head>

<body>
    <div class="container">
        <header>
            <h1>ブログ作成</h1>
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
            <section class="create-blog">
                <h2>新しいブログを作成する</h2>
                <form id="blogForm" action="{{ route('user.blog.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="title">タイトル:</label>
                        <input type="text" name="title" id="title" required>
                    </div>
                    <div>
                        <label for="contents">内容:</label>
                        <textarea name="contents" id="contents" required></textarea>
                    </div>
                    <button type="submit">投稿する</button>
                </form>
                <button type="button" onclick="clearDraft()">下書きをクリア</button>
                <div class="preview" id="preview"></div>
            </section>
        </main>
        <footer>
            <p>&copy; cingroup</p>
        </footer>
    </div>
</body>

</html>
