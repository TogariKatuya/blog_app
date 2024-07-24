<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ブログ詳細</title>
    <link rel="stylesheet" href="/css/info.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('../js/good.js') }}"></script>
</head>

<body>
    <div class="container">
        <header>
            <h1>ブログ詳細</h1>
            <nav>
                <ul>
                    <li><a href="/user">ホーム</a></li>
                    <li><a href="/search">検索</a></li>
                    <li>
                        <form action="{{ route('user.login.destroy') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <section class="blog-detail">
                <article>
                    <h2>{{ $blog->title }}</h2>
                    <p><strong>作成者:</strong> {{ $blog->user->first_name }}</p>
                    @if ($blog->images->isNotEmpty())
                        <img src="{{ asset('storage/images/' . $blog->images->first()->filename) }}" alt="Blog Image"
                            class="blog-image">
                    @endif
                    <p><strong>作成日:</strong> {{ $blog->created_at->format('Y年m月d日') }}</p>
                    <p><strong>観覧数:</strong> {{ $blog->views }}</p>

                    <div class="content">
                        {!! \Illuminate\Support\Str::markdown($blog->contents) !!}
                    </div>

                    <div class="like-section">
                        <button class="like-button" data-article-id="{{ $blog->id }}">
                            <i class="fa fa-heart"></i>
                        </button>
                        <span id="like-count">{{ $blog->goods->count() }}</span>
                    </div>
                </article>
            </section>

            <section class="comments">
                <h3>コメント</h3>
                <form action="{{ route('blog.comment', $blog->id) }}" method="POST">
                    @csrf
                    <textarea name="comment" placeholder="コメントを入力..." required></textarea>
                    <button type="submit">コメントを投稿</button>
                </form>

                <ul class="comment-list">
                    @forelse ($blog->comments as $comment)
                        <li>
                            <p>{{ $comment->user->first_name }}: {{ $comment->body }}</p>
                            <p class="comment-date">{{ $comment->created_at->format('Y年m月d日 H:i') }}</p>
                        </li>
                    @empty
                        <p>コメントはまだありません。</p>
                    @endforelse
                </ul>
            </section>
        </main>
        <footer>
            <p>&copy; cingroup</p>
        </footer>
    </div>
</body>

</html>
