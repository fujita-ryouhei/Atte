<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <h1 class="header-ttl">Atte</h1>
            <nav class="header-nav">
                <ul class="header-nav-list">
                    <li class="header-nav-item"><a href="/" class="header-nav-item-link">ホーム</a></li>
                    <li class="header-nav-item"><a href="/attendance" class="header-nav-item-link">日付一覧</a></li>
                    <li class="header-nav-item"><a href="/logout" class="header-nav-item-link">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="greeting">
            <h2 class="greeting-message">Xさんお疲れ様です！</h2>
        </div>
        <div class="attendance-grid">
            <div class="attendance-form">
                <form action="" method="post" class="punchIn">
                    <button type="submit">勤務開始</button>
                </form>
                <form action="" method="post" class="punchOut">
                    <button type="submit">勤務終了</button>
                </form>
            </div>
            <div class="break-form">
                <form action="" method="post" class="breakIn">
                    <button type="submit">休憩開始</button>
                </form>
                <form action="" method="post" class="breakOut">
                    <button type="submit">休憩終了</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <small>Atte,inc.</small>
    </footer>
</body>
</html>