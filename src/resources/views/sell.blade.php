@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('content')

<div class="sell_content">
    <h3>商品の出品</h3>
    <form action="" method="post">
    @csrf
    <div class="product_img">
        <div class="img_label">商品画像</div>
        <div class="image-upload-box">
            <label for="image" class="upload-label">
                <span class="upload-text">画像を選択する</span>
                <input type="file" name="image" id="image" class="hidden-input" accept="image/*">
            </label>
        </div>
        <div id="preview"></div>
    </div>
    <div class="product_category">
        <div class="category_label">商品の詳細</div>
        <div class="category_name">カテゴリー</div>
        <div class="category_main">
            @foreach ( $categories as $category )
            {{ $category->name }}
            @endforeach
        </div>
    </div>
    <div class="product_condition">
        <div class="condition_label">商品の状態</div>
        <select name="condition_id" id="condition_id">
            <option value="">選択してください</option>
            @foreach ($conditions as $condition)
                <option value="{{ $condition->id }}">
                    {{ $condition->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="product_name-detail">
        <div class="name-detail_label">商品名と説明</div>
        <div class="product_name">
            <div class="name_label">商品名</div>
            <input type="text" name="name" value="{{ old('name') }}" />
        </div>
        <div class="brand_name">
            <div class="brand_label">ブランド名</div>
            <input type="text" name="brand_name" value="{{ old('brand_name') }}" />
        </div>
        <div class="product_detail">
            <div class="detail_label">商品の説明</div>
            <input type="text" name="explanation" value="{{ old('explanation') }}" />
        </div>
        <div class="product price">
            <div class="price_label">販売価格</div>
            <input type="integer" name="price" placeholder="¥" value="{{ old('price') }}" />
        </div>
    </div>
    <div class="sell_btn">
        <button class="sell_button" type="submit">出品する</button>
    </div>
</div>