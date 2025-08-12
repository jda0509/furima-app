<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <a href="/" class="header__logo__link">
                    <img class="header__logo__image" src="" alt="ロゴ">
                </a>
            </div>
            <div class="header__center">
            @auth
                <form action="{{ route('index') }}" class="header__search" method="get" >
                    <input class="header__searchbox" type="text" name="search" placeholder="なにをお探しですか？" value="{{ request('search') }}">
                </form>
            @else
                <a href="/login" class="header__searchbox">
                    <input class="header__searchbox" type="text" placeholder="なにをお探しですか？" />
                </a>
            @endauth
            </div>
            <nav class="header__content">
                <ul class="header__nav">
                    @auth
                        <li>
                            <form method="post" action="/logout" >
                                @csrf
                                <button class="header__logout__button">ログアウト</button>
                            </form>
                        </li>
                        <li><a class="header__mypage" href="{{ route('mypage.show') }}">マイページ</a></li>
                        <li><a class="header__sell" href="/sell">出品</a></li>
                    @else
                        <li><a class="header__login" href="/login">ログイン</a></li>
                        <li><a class="header__mypage" href="/login">マイページ</a></li>
                        <li><a class="header__sell" href="/login">出品</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>