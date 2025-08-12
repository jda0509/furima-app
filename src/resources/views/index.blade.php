@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@php
use Illuminate\Support\Str;
@endphp

@section('content')

<div class="main__content">
    <div class="main__content__tab">
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'sell']) }}" class="tab {{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
        @auth
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'mylist']) }}" class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
        @else
        <a href="/login" class="tab__favorite">マイリスト</a>
        @endauth
    </div>

    <div class="product-list">
        @if (request('tab') === 'mylist' && Auth::check())
            {{-- マイリスト用一覧 --}}
            @forelse ($likesProducts as $product)
                <a href="{{ route('item.show' , [ 'item_id' => $product->id, 'search' => request('search'),'tab' => request('tab') ]) }}" >
                    <img class="product__img" src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' .$product->image) }}" alt="{{ $product->name }}" >
                    <div class="product__name">{{ $product->name }}</div>
                </a>
            @empty
                <p class="message">お気に入りの商品がありません。</p>
            @endforelse
        @else
            {{-- 通常のおすすめ一覧 --}}
            @forelse ($products as $product)
                <a href="{{ route('item.show' , [ 'item_id' => $product->id, 'search' => request('search'), 'tab' => request('tab') ]) }}" >
                    <img class="product__img" src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' .$product->image) }}" alt="{{ $product->name }}" >
                    <div class="product">{{ $product->name }}</div>
                </a>
            @empty
                <p class="message">商品がまだ登録されていません</p>
            @endforelse
        @endif
    </div>
</div>

@endsection