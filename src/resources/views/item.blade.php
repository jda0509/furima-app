@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@php
use Illuminate\Support\Str;
@endphp

@section('content')

<div class="product">
    <div class="product__image">
        <img class="product__image__detail" alt="商品画像" src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}">
    </div>
    <div class="product__detail">
        <h2 class="product__detail__name">{{ $product->name }}</h2>
        <div class="product__detail__brand_name">{{ $product->brand_name ? $product->brand_name : '' }}</div>
        <div class="product__detail__price">¥{{ number_format ( $product->price )}}（税込）</div>
        <form method="POST" action="{{ route('products.like' , ['product' => $product->id]) }}">
            @csrf
            <button type="submit" style="background:none; border:none; padding:0;">
            <div class="product__detail__favorite">
            @auth
                {{-- いいね切り替えアイコン表示（ログインユーザーのみ） --}}
                @if($product->likesUsers->contains('id',auth()->id()))
                    <img class="favorite" src="{{ asset('storage/images/favorite.png') }}" alt="お気に入り済み">
                @else
                    <img class="favorite" src="{{ asset('storage/images/no-favorite.png') }}" alt="お気に入り未登録">
                @endif
            @else
                <img class="favorite" src="{{ asset('storage/images/no-favorite.png') }}" alt="お気に入り未登録">
            @endauth
                <div class="favorite_count">{{ $product->likesUsers()->count() }}</div>
            </div>
        </form>
        <div class="product__detail__simple-comment">
            <img src="{{ asset('storage/images/comment.png') }}" alt="コメントアイコン" class="simple-comment-icon">
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
        @foreach($product->comments as $comment)
            @auth
                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="アイコン" class="comment__user__image">
                <div class="comment__user__name" >{{ Auth::user()->name }}</div>
                <div class="comment__content">{{ $comment->comment }}</div>
            @endauth
            @guest
                <img src="{{ asset('storage/') }}" alt="adminアイコン" class="comment__user__image">
                <p class="comment__user__name">admin</p>
            @endguest
        </div>
        @endforeach
        <h3 class="product__comment__main">商品へコメント</h3>
        <form action="{{ route('comments.store', ['item' => $product->id]) }}" method="POST">
        @csrf
            <textarea name="comment" id="" class="comment__main__content"></textarea>
        @auth
            <button class="comment-btn" type="submit">コメントを送信する</button>
        @else
            <a href="/login" class="comment-btn">コメントを送信する</a>
        @endauth
        </form>
    </div>
</div>

@endsection