@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@php
use Illuminate\Support\Str;
@endphp

@section('content')

<div class="mypage">
    <div class="user_info">
        <div class="user_info_image">
            @if (isset($user->profile->image))
                <img src="{{ Str::startsWith($user->profile->image, 'http') ? $user->profile->image : asset('storage/' . $user->profile->image) }}" alt="プロフィール画像" >
            @else
                <img src="{{ asset('storage/images/default_icon.png') }}" alt="デフォルト画像">
            @endif
        </div>
        <div class="user_info_name">{{ $user->name }}</div>
        <a href="mypage/profile" class="profile_change_link">プロフィールを編集</a>
    </div>

    @php
        $tab = request()->get('tab', 'sell');
    @endphp
    <ul class="tab_menu">
        <li><a href="{{ route('mypage.show') }}?tab=sell" class="{{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a></li>
        <li><a href="{{ route('mypage.show') }}?tab=buy" class="{{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a></li>
    </ul>
    <div class="product_list">
        @if ($tab === 'sell')
            @foreach ($myProducts as $product)
            <div class="product" >
                <a class="product_link" href="{{ route('item.show' , [ 'item_id' => $product->id ]) }}" >
                    <img class="product__img" src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image ) }}" alt="{{ $product->name }}" >
                    <p>{{ $product->name }}</p>
                </a>
            </div>
            @endforeach
        @elseif ($tab === 'buy')
            @foreach ( $myPurchases as $order)
            <div class="product" >
                <a class="product_link" href="{{ route('item.show' , [ 'item_id' => $order->product->id ]) }}" >
                    <img class="product__img" src="{{ Str::startsWith($order->product->image, 'http') ? $order->product->image : asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name }}" >
                    <p>【Sold】{{ $order->product->name}}</p>
                </a>
            </div>
            @endforeach
        @endif
    </div>
</div>

@endsection