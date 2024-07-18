<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User</title>

</head>

<body>
    <main>
        <form method="POST" action="{{ route('user.login.store') }}">
            @csrf
            <div>
                <label for="name">Name: </label>
                <input type="text" id="name" name="name" required />
            </div>
            <div>
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" required />
            </div>
            <div>
                @error('failed')
                    <p>{{ $message }}</p>
                @enderror
                <button type="submit">ログイン</button>
            </div>
        </form>
    </main>
</body>

</html>
