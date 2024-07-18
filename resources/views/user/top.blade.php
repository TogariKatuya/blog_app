<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User</title>
</head>

<body>
    <main>
        @auth('user')
            <p>ログイン中です。</p>
        @endauth
        <form method="POST" action="{{ route('user.login.destroy') }}">
            @method('DELETE')
            @csrf
            <button type="submit">ログアウト</button>
        </form>
    </main>
</body>

</html>
