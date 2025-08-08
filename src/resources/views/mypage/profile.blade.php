@extends('layouts.header')
@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('content')


<div class="profile">
    <div class="profile__content">
        <h2 class="profile__content__title">プロフィール設定</h2>
        @if (isset($profile))
            <form action = "{{ route('mypage.profile.update') }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
        @else
            <form action="{{ route('profile.store', ['user_id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
        @endif
            <div class="profile__content__image">
                @if (isset($user->profile->image))
                    <img src="{{ Str::startWith($user->profile->image, 'http') ? $user->profile->image : asset('storage/' . $user->profile->image) }}" alt="プロフィール画像" >
                @else
                    <img src="" alt="デフォルト画像">
                @endif
                <label for="image_input" class="file_label">画像を選択する</label>
                <input class="hidden__img__submit" type="file" name="image" accept="image/*">
            </div>
            <div class="profile__content__name">
                <div class="profile__name__label">ユーザー名</div>
                <input class="name__input" type="text" name="name" value="{{ old('name', $user->name ?? '')}}" />
            </div>
            <div class="error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="profile__content__postcode">
                <div class="profile__postcode__label">郵便番号</div>
                <input class="postcode__input" type="text" name="postcode" value="{{ old('postcode',$user->profile->postcode ?? '') }}" />
            </div>
            <div class="error">
                @error('postcode')
                {{ $message }}
                @enderror
            </div>
            <div class="profile__content__address">
                <div class="profile__address__label">住所</div>
                <input class="address__input" type="text" name="address" value="{{ old('address',$user->profile->address ?? '') }}" />
            </div>
            <div class="error">
                @error('address')
                {{ $message }}
                @enderror
            </div>
            <div class="profile__content__building">
                <div class="profile__building__label">建物名</div>
                <input class="building__input" type="text" name="building" value="{{ old('building',$user->profile->building ?? '') }}" />
            </div>
            <button class="profile__button" type="submit">更新する</button>
        </form>
    </div>
</div>


@endsection