<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <h1 class="header-ttl">Atte</h1>
        </div>
    </header>

    <main>
        <div class="login-group">
            <div class="login-ttl">
                <h2>ログイン</h2>
            </div>
            <form action="" method="get" class="login-form">
                <input type="email" name="email" id="email" placeholder="メールアドレス">
                <input type="text" name="password" id="password" placeholder="パスワード">
                <button type="submit" class="login-button">ログイン</button>
            </form>
            <div class="register">
                <p>アカウントをお持ちでない方はこちらから</p>
                <a href="/register" class="move-register">会員登録</a>
            </div>
        </div>
    </main>

    <footer>
        <small>Atte,inc.</small>
    </footer>
</body>
</html>