@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<script src="{{ asset('/js/upload_image.js') }}"></script>
@endsection

@section('header-item')

@include('layouts.search-form')
<div class="header-nav">
    <nav>
        <ul class="header-nav__group">
            <li class="header-nav__list">
                <form class="header-nav__list-item" action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="header-nav__list-item">ログアウト</button>
                </form>
            </li>
            <li class="header-nav__list">
                <a class="header-nav__list-item" href="/mypage">マイページ</a>
            </li>
            <li class="header-nav__list">
                <a class="header-nav__list-item link--exhibition" href="/sell">出品</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="content--small">
    <div class="common-ttl">プロフィール設定</div>
    <div class="form">
        <form class="form__inner" action="/mypage/profile" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="image-group">
                @if (!$profile)
                <div class="image-container no-image circle">
                    <img id="preview" class="image-container__image" src="" style="display: none">
                </div>
                @else
                <div class="image-container circle">
                    <img id="currentImage" class="image-container__image"
                        src="{{asset('storage/images/' . $profile->user_image)}}" alt="ユーザーアイコン">
                    <img id="preview" class="image-container__image preview-image" src="" style="display: none">
                </div>
                @endif
                <label for="imageInput" class="link-bottun--border">画像を選択する
                    <input class="input-image" type="file" accept=".jpeg,.png" name="user_image" id="imageInput">
                </label>
            </div>
            <p class="error-message">
                @error('user_image')
                {{$message}}
                @enderror
            </p>
            <div class="form-item">
                <label class="form-item__label">ユーザー名</label>
                <input class="form-item__input" type="text" name="name" value="{{$user->name}}">
            </div>
            <p class="error-message">
                @error('name')
                {{$message}}
                @enderror
            </p>
            <div class="form-item">
                <label class="form-item__label">郵便番号</label>
                <input class="form-item__input" type="text" name="postcode" value="{{$profile->postcode ?? ''}}">
            </div>
            <p class="error-message">
                @error('postcode')
                {{$message}}
                @enderror
            </p>
            <div class="form-item">
                <label class="form-item__label">住所</label>
                <input class="form-item__input" type="text" name="address" value="{{$profile->address ?? ''}}">
            </div>
            <p class="error-message">@error('address')
                {{$message}}
                @enderror</p>
            <div class="form-item">
                <label class="form-item__label">建物名</label>
                <input class="form-item__input" type="text" name="building" value="{{$profile->building ?? ''}}">
            </div>
            <p class="error-message">@error('building')
                {{$message}}
                @enderror</p>
            <div class="form-item">
                <button class="form-item__button">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection