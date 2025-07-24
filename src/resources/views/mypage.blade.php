@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')

<div class="mypage">
    <div class="user_info">
        <div class="user_info_image">
            @if (isset($user->profile->image))
                <img src="{{ asset('storage/' . $user->profile->image) }}" alt="プロフィール画像" >
            @else
                <img src="" alt="デフォルト画像">
            @endif
        </div>
        <div class="user_info_name">ユーザー名</div>
        <a href="mypage/profile" class="profile_change_link">プロフィールを編集する</a>
    </div>

    <div class="product_list">
        @php
            $tab = request()->get('tab', 'sell');
        @endphp
        <ul class="tab_menu">
            <li><a href="{{ route('mypage.show') }}?tab=sell">出品した商品</li>
            <li><a href="{{ route('mypage.show') }}?tab=buy">購入した商品</li>
        </ul>
        @if ($tab === 'sell')
            @foreach ($myProducts as $product)
                <a href="{{ route('item.show' , [ 'item_id' => $product->id ]) }}" >
                    <img class="product__img" src="{{ asset('storage/' . $product->image ) }}" alt="{{ $product->name }}" >
                    <p>{{ $product->name }}</p>
                </a>
            @endforeach
        @elseif ($tab === 'buy')
            @foreach ( $myPurchases as $order)
                <a href="{{ route('item.show' , [ 'item_id' => $order->product->id ]) }}" >
                    <img class="product__img" src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name }}" >
                    <p>【Sold】{{ $order->product->name}}</p>
                </a>
            @endforeach
        @endif
    </div>
</div>

@endsection