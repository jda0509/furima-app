@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('content')

<div class="buy__main_content">
    <div class="buy__left">
        <form action="{{ route('purchase.store') }}" method="post">
        @csrf
        <div class="buy__product">
            <img class="product__img" src="{{ $product->image }}" alt="{{ $product->name }}" >
            <div class="product__info">
                <div class="product__name">{{ $product->name }}</div>
                <div class="product__price">¥{{ number_format ( $product->price ) }}</div>
            </div>
        </div>
        </form>
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="payment_method">
            <div class="payment_method__label">支払い方法</div>
            <div class="payment_method__select">
                <select name="payment_method" id="payment_method" class="payment_method__main" required>
                    <option value="" selected disabled>選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード支払い">カード支払い</option>
                </select>
            </div>
        </div>
        <div class="sending_address">
            <div class="sending_address__label">配送先</div>
            <div class="sending_address__change">
                <a href="{{ route('purchase.address', ['item_id' => $product->id ]) }}" class="sending_address__link">変更する</a>
            </div>
        </div>
        <div class="last_order__sending">
            @if ($lastOrder)
                <p class="last_order__postcode">〒{{ $lastOrder->sending_postcode }}</p>
                <p class="last_order__address">
                    {{ $lastOrder->sending_address }}
                    @if (!empty($lastOrder->sending_building))
                        {{ $lastOrder->sending_building }}
                    @endif
                </p>
            @elseif (Auth::check())
                <p class="last_order__postcode">〒{{ Auth::user()->profile->postcode }}</p>
                <p class="last_order__address_building">
                    {{ Auth::user()->profile->address }} {{ Auth::user()->profile->building }}
                </p>
            @endif
        </div>
    </div>
    <div class="buy__right">
        <div class="subtotal_table">
            <div class="table__price">
                <span class="table__label">商品代金</span>
                <span class="price__value">¥{{ number_format ( $product->price )}}</span>
            </div>
            <div class="table__payment">
                <span class="table__label">決済方法</span>
                <span class="payment__value" id="payment_summary">選択してください</span>
            </div>
        </div>
        <form action="{{ route('checkout.start') }}" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $product->id }}">
            <button class="buy__button" type="submit">購入する</button>
        </form>
    </div>
    <script>
        document.getElementById('payment_method').addEventListener('change',function(){
        document.getElementById('payment_summary').textContent = this.value;
        });
    </script>
</div>

@endsection