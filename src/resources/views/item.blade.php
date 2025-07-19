@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@section('content')

<div class="product">
    <div class="product__image">
        <img class="product__image__detail" alt="商品画像" src="">
    </div>
    <div class="product__detail">
        <h2 class="product__detail__name">{{ $product->name }}</h2>
        <div class="product__detail__brand_name">{{ $product->brand_name }}</div>
        <div class="product__detail__price">¥{{ number_format ( $product->price )}}（税込）</div>
        <div class="product__detail__favorite">
        @auth
            {{-- いいね切り替えアイコン表示（ログインユーザーのみ） --}}
            @if($product->likesUsers->contains('id',auth()->id()))
                <img class="favorite" src="" alt="お気に入り済み">
            @else
                <img class="favorite" src="" alt="お気に入り未登録">
            @endif
        @endauth
            <div class="favorite_count">{{ $product->likesUsers()->count() }}</div>
        </div>
        <div class="product__detail__simple-comment">
            <img src="" alt="コメントアイコン" class="simple-comment-icon">
            <div class="simple-comment-count">{{ $product->comments()->count() }}</div>
        </div>
        <div class="product__detail__buy">
            @auth
            <a href="{{ route('purchase.create', [ 'item_id' => $product->id]) }}" class="buy-button">購入手続きへ</a>
            @else
            <a href="/login" class="buy-button">購入手続きへ</a>
            @endauth
        </div>
    </div>
    <div class="product__explain">
        <h2 class="product__explain__title">商品説明</h2>
        <div class="product__explain__main">{{ $product->explanation }}</div>
    </div>
    <div class="product__information">
        <h2 class="product__information__title">商品情報</h2>
        <div class="product__information__category">
            <div class="category__title">カテゴリー</div>
            <div class="category__detail">
                @foreach ( $product->categories as $category )
                    <span class="category-tag">{{ $category->name }}</span>
                @endforeach
            </div>
        </div>
        <div class="product__information__condition">
            <div class="condition__title">商品の状態</div>
            <div class="condition__detail">{{ $product->condition->name }}</div>
        </div>
    </div>
    <div class="product__comment">
        <h2 class="product__comment__title">コメント（{{ $product->comments()->count() }}）</h2>
        <div class="product__comment__user">
            @auth
                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="アイコン" class="comment__user__image">
                {{ Auth::user()->name }}
            @endauth
            @guest
                <img src="{{ asset('storage/') }}" alt="adminアイコン" class="comment__user__image">
                <p class="comment__user__name">admin</p>
            @endguest
        </div>
        <h3 class="product__comment__main">商品へコメント</h3>
        <form action="" class="product__comment__main__form" method="POST"></form>
        @csrf
        <textarea name="comment" id="" class="comment__main__content"></textarea>
        @auth
        <button class="comment-btn" type="submit">コメントを送信する送信</button>
        @else
        <a href="/login" class="comment-btn">コメントを送信する</a>
        @endauth
    </div>
</div>

@endsection