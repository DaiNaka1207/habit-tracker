<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <p>{{ $user->name }} さん、おはようございます！</p>
    <p>今日も習慣を続けましょう。</p>
    <ul>
        @foreach ($user->habits as $habit)
            <li>{{ $habit->name }}</li>
        @endforeach
    </ul>
</body>
</html>
