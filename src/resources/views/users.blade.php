<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
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
        <table>
            <tr>
                <th>名前</th>
                @foreach ($weekDates as $date)
                    <th>{{ $date->format('m/d') }}</th>
                @endforeach
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    @foreach ($weekDates as $date)
                        <td>
                            @foreach ($attendanceData[$user->id] as $attendance)
                                @if ($attendance->created_at->format('Y-m-d') === $date->format('Y-m-d'))
                                    ○
                                @else
                                    -
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
        {{ $userName->links() }}
    </main>

    <footer>
        <small>Atte,inc.</small>
    </footer>
</body>
</html>