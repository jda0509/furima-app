@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('content')

<div class="profile">
    <div class="profile__content">
        <h3 class="profile__content__title">プロフィール設定</h3>
        @if (isset($profile))
            <form action = "{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
        @else
            <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
        @endif
            @csrf
            <div class="profile__content__image">
                @if (isset($user->profile->image))
                    <img src="{{ asset('storage/' . $user->profile->image) }}" alt="プロフィール画像" >
                @else
                    <img src="" alt="デフォルト画像">
                @endif
                <input class="img__submit" type="image" name="image" value="画像を編集する" />
            </div>
            <div class="profile__content__name">
                <div class="profile__name__label">ユーザー名</div>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '')}}" />
            </div>
            <div class="error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="profile__content__postcode">
                <div class="profile__postcode__label">郵便番号</div>
                <input type="text" name="postcode" value="{{ old('postcode', $user->postcode ?? '' )}}" />
            </div>
            <div class="error">
                @error('postcode')
                {{ $message }}
                @enderror
            </div>
            <div class="profile__content__address">
                <div class="profile__address__label">住所</div>
                <input type="text" name="address" value="{{ old('address' , $user->address ?? '' )}}" />
            </div>
            <div class="error">
                @error('address')
                {{ $message }}
                @enderror
            </div>
            <div class="profile__content__building">
                <div class="profile__building">建物名</div>
                <input type="text" name="building" value="{{ old('building' ,$user->building ?? '' )}}" />
            </div>
            <button class="profile__button" type="submit">更新する</button>
        </form>
    </div>
</div>