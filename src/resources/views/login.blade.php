<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__logo">
            <a href="/" class="header__logo__link">
                <image class="header__logo__image" src="" alt="ロゴ">
            </a>
        </div>
    </header>

    <div class="login">
        <div class="login__content">
        <h3 class="login__title">ログイン</h3>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="login__content__email">
                    <div class="email__label">メールアドレス</div>
                    <input type="email" name="email" value=""/>
                </div>
                <div class="error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="login__content__password">
                    <div class="password__label">パスワード</div>
                    <input type="password" name="password" value="" />
                </div>
                <div class="error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <div class="login__content__submit">
                    <button class="login__btn" type="submit">ログインする</button>
                </div>
            </form>
            <a href="/register" class="register__link">会員登録はこちら</a>
        </div>
    </div>
</body>