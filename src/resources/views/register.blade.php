<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <h1 class="header-ttl">Atte</h1>
        </div>
    </header>

    <main>
        <div class="register-group">
            <div class="register-ttl">
                <h2>会員登録</h2>
            </div>
            <form action="/register" method="post" class="register-form">
                @csrf
                <input type="text" name="name" id="name" placeholder="名前" value="{{ old('name') }}">
                <input type="email" name="email" id="email" placeholder="メールアドレス" value="{{ old('email') }}">
                <input type="password" name="password" id="password" placeholder="パスワード">
                <input type="password" name="password_confirmation" id="password" placeholder="確認用パスワード">
                <button type="submit" class="register-button">会員登録</button>
            </form>
            <div class="login">
                <p>アカウントをお持ちの方はこちらから</p>
                <a href="/signIn" class="move-login">ログイン</a>
            </div>
        </div>
    </main>

    <footer>
        <small>Atte,inc.</small>
    </footer>
</body>
</html>