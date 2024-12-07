@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile_edit.css')}}">
@endsection

@section('header-item')
<div class="header-search">
    <form class="header-search-form" action="">
        @csrf
        <input class="header-search-form__input" type="text" placeholder="何をお探しですか？">
    </form>
</div>
<div class="header-nav">
    <nav>
        <ul class="header-nav__group">
            <li class="header-nav__list">
                <a class="header-nav__list-item" href="/logout">
                    ログアウト
                </a>
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
        <form class="form__inner" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="image-group">
                <div class="image-container--circle">
                    <img class="image-container__image" src="" alt="">
                </div>
                <label for="profile_image" class="link-bottun--border">画像を選択する
                    <input class="input-image" type="file" accept=".jpeg,.png" name="profile_image" id="profile_image">
                </label>
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">ユーザー名</label>
                <input class="form-item__input" type="text">
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">郵便番号</label>
                <input class="form-item__input" type="text">
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">住所</label>
                <input class="form-item__input" type="text">
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">建物名</label>
                <input class="form-item__input" type="text">
            </div>
            <div class="form-item">
                <button class="form-item__button">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection