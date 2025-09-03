@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}" />
@endsection

@section('content')

<div class="address">
    <h2 class="address_title">住所の変更</h2>
    <form action="{{ route('sending.store',['item_id' => $product->id ])}}" method="post">
        @csrf
        <div class="address_main">
            <div class="address_main_postcode">
                <div class="postcode_label">郵便番号</div>
                <input type="text" name="postcode" class="postcode_form" value="{{ old('postcode', $lastOrder->sending_postcode ?? '') }}"/>
            </div>
            <div class="error">
                @error('postcode')
                {{ $message }}
                @enderror
            </div>
            <div class="address_main_address">
                <div class="address_label">住所</div>
                <input type="text" name="address" class="address_form" value="{{ old('address', $lastOrder->sending_address ?? '') }}"/>
            </div>
            <div class="error">
                @error('address')
                {{ $message }}
                @enderror
            </div>
            <div class="address_main_building">
                <div class="building_label">建物名</div>
                <input type="text" name="building" class="building_form" value="{{ old('building', $lastOrder->sending_building ?? '') }}"/>
            </div>
            <div class="address_submit">
                <button class="address_button" type="submit">更新する</button>
            </div>
        </div>
    </form>
</div>

@endsection