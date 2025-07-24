@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('content')

<div class="sell_content">
    <h3>商品の出品</h3>
    <form action="{{ route('items.store') }}" method="post">
    @csrf
    <div class="product_img">
        <div class="img_label">商品画像</div>
        <div class="image-upload-box">
            <label for="image_input" class="block mb-2">画像を選択する</label>
            <input type="file" name="image" id="image_input" class="mb-4" accept="image/*">
            <div id="preview_container" class="w-64 h-64 border border-gray-300 flex items-center justify-center">
                <img id="image_preview" src="#" alt="" class="hidden object-cover w-full h-full" />
            </div>
        </div>
    </div>
    <div class="product_category">
        <div class="category_label">商品の詳細</div>
        <div class="category_name">カテゴリー</div>
        <div class="category_main">
            @foreach ( $categories as $category )
                <input type="checkbox" id="category_{{ $category->id }}" name="categories[]" value="{{ $category->id }}" class="sr-only peer">
                <label for="category_{{ $category->id }}" class="category-label peer-checked:bg-blue-600 peer-checked:text-white">
                    {{ $category->name }}
                </label>
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
    </form>
</div>

<script>
document.getElementById('image_input').addEventListener('change', function (event){
    const file = event.target.files[0];
    const preview = document.getElementById('image_preview');

    if(file){
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }

        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.classList.add('hidden');
    }
});
</script>

@endsection