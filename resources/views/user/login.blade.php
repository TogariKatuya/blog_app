<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popup_form.css') }}">
</head>

<body>
    <h1>User Login</h1>
    <main>
        <form method="POST" action="{{ route('user.login.store') }}">
            @csrf
            @method('')
            <div>
                <label for="first_name">Name: </label>
                <input type="text" id="first_name" name="first_name" required />
            </div>
            <div>
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" required />
            </div>
            <div>
                @error('failed')
                    <p>{{ $message }}</p>
                @enderror
                <button type="submit">Login</button>
            </div>
        </form>

        <!-- ポップアップを開くボタン -->
        <button id="openModalBtn">new account</button>
    </main>

    <!-- ポップアップのHTMLを読み込む -->
    @include('user.popup_form')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/popup_form.js') }}"></script>
</body>

</html>
