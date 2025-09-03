1.プロジェクト名
    フリマアプリ

2.概要
    ユーザーが商品を出品・購入できるフリマアプリのサンプルプロジェクト。

3.環境
    - PHP 8.x
    - Laravel 10.x
    - MySQL 8.x

4.インストール手順
    git clone git@github.com:jda0509/furima-app.git
    cd furima-app
    composer install
    cd .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan serve

5.テスト方法
    php artisan test --env.testing

6.備考
    Soldラベルは売り切れの商品に表示
    管理者機能はなし
