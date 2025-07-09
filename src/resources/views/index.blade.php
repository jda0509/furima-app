@extends('layouts.header') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')

<div class="main__content">
    <div class="main__content__tab">
        <a href="" class="tab__recommend">おすすめ</a>
        @auth
        <a href="" class="tab__favorite">マイリスト</a>
        @else
        <a href="/login" class="tab__favorite">マイリスト</a>
    </div>

    <div class="product-list">
        @if (request('tab') === 'mylist' && Auth::check())
            {{-- マイリスト用一覧 --}}
            @forelse ($likedProducts as $product)
                <image class="product__img" src="{{ asset('storage/' . $product->img_url) }}" alt="{{ $product->name }}" >
                <div class="product__name">{{ $product->name }}</div>
            @empty
                <p class="message">お気に入りの商品がありません。</p>
            @endforelse
        @else
            {{-- 通常のおすすめ一覧 --}}
            @forelse ($products as $product)
                <image class="product__img" src="{{ asset('storage/' . $product->img_url) }}" alt="{{} $product->name }}" >
                <div class="product">{{ $product->name }}</div>
            @empty
                <p class="message">商品がまだ登録されていません</p>
            @endforelse
        @endif
    </div>
</div>