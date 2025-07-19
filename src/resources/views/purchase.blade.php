@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('content')

<div class="buy__main_content">
    <form action="{{ route('purchase.store') }}" method="post">
    @csrf
    <div class="buy__product">
        <img class="product__img" src="{{ $product->image }}" alt="{{ $product->name }}" >
        <div class="product__name">{{ $product->name }}</div>
        <div class="product__price">¥{{ number_format ( $product->price ) }}</div>
    </div>
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <div class="payment_method">
        <div class="payment_method__label">支払い方法</div>
        <select name="payment_method" id="payment_method" class="payment_method__main" required>
            <option value="" selected disabled>選択してください</option>
            <option value="コンビニ払い">コンビニ払い</option>
            <option value="カード支払い">カード支払い</option>
        </select>
    </div>
    <div class="sending_address">
        <div class="sending_address__label">配送先</div>
        <div class="sending_address__change">
            <a href="{{ route('purchase.address', ['item_id' => $product->id ]) }}" class="sending_address__link">変更する</a>
        </div>
        @if ($lastOrder)
            <p class="last_order__address">{{ $lastOrder->sending_address}}</p>
        @else
            <p class="last_order__postcode">{{ Auth::user()->profile->postcode }}</p>
            <p class="last_order__address_building">{{ Auth::user()->profile->address }} {{ Auth::user()->profile->building }}</p>
        @endif
    </div>
    <div class="subtotal_table">
        <div class="table__label">
            <span class="table__label__price">商品代金</span>
            <span class="table__label__payment">決済方法</span>
        </div>
        <div class="table__value">
            <span class="price__value">¥{{ number_format ( $product->price )}}</span>
            <span class="payment__value" id="payment-summary">選択してください</span>
        </div>
        <script>
            document.getElementById('payment-method').addEventListener('change',function(){
                document.getElementById('payment-summary').textContent = this.value;
            });
        </script>
    </div>
    <button class="buy__product__submit" type="submit">購入する</button>
    </form>
</div>

@endsection