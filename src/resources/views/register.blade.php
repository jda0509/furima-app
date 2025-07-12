<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__logo">
            <a href="/" class="header__logo__link">
                <image class="header__logo__image" src="" alt="ロゴ">
            </a>
        </div>
    </header>

    <div class="register">
        <div class="register__content">
            <h3 class="register__content__title">会員登録</h3>
            <form action="" method="post">
            @csrf
                <div class="register__content__name">
                    <div class="name__label">ユーザー名</div>
                    <input type="text" name="name" value="" />
                </div>
                <div class="error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
                <div class="register__content__email">
                    <div class="email__label">メールアドレス</div>
                    <input type="email" name="email" value="" />
                </div>
                <div class="error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="register__content__password">
                    <div class="password__label">パスワード</div>
                    <input type="password" name="password" value="" />
                </div>
                <div class="error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <div class="register__content__password__confirmation">
                    <div class="password__confirmation__label">確認用パスワード</div>
                    <input type="password" name="password__confirmation" value="" />
                </div>
                <div class="error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <div class="register__content__button">
                    <button class="register__btn">登録する</button>
                </div>
            </form>
            <a href="/login" class="login__link">ログインはこちら</a>
        </div>
    </div>