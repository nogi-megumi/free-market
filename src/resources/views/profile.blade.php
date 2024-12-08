@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
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
<div class="content--large">
    <div class="profile-group">
        <div class="profile-group__user-info">
            <div class="image-container--circle">
                <img class="image-container__image" src="" alt="ユーザーアイコン">
            </div>
            <p class="profile-group__user-name">ユーザー名</p>
        </div>
        <div class="link-bottun">
            <a class="link-bottun--border" href="">
                プロフィールを編集
            </a>
        </div>
    </div>
    <div class="tab-group">
        <a class="tab-group__tab" href="">出品した商品</a>
        <a class="tab-group__tab" href="">購入した商品</a>
    </div>
    <div class="item-index">
        <div class="item-index__item-group">
            <a href="">
                <div class="image-container--square">
                    <img class="image-container__image" src="" alt="商品画像">
                </div>
                <p class="item-name">商品名</p>
            </a>
        </div>
        <div class="item-index__item-group">
            <a href="">
                <div class="image-container--square">
                    <img class="image-container__image" src="" alt="商品画像">
                </div>
                <p class="item-name">商品名</p>
            </a>
        </div>
        <div class="item-index__item-group">
            <a href="">
                <div class="image-container--square">
                    <img class="image-container__image" src="" alt="商品画像">
                </div>
                <p class="item-name">商品名</p>
            </a>
        </div>
        <div class="item-index__item-group">
            <div class="image-container--square">
                <img class="image-container__image" src="" alt="商品画像">
            </div>
            <p class="item-name">商品名</p>
        </div>
        <div class="item-index__item-group">
            <div class="image-container--square">
                <img class="image-container__image" src="" alt="商品画像">
            </div>
            <p class="item-name">商品名</p>
        </div>
        <div class="item-index__item-group">
            <div class="image-container--square">
                <img class="image-container__image" src="" alt="商品画像">
            </div>
            <p class="item-name">商品名</p>
        </div>
    </div>
</div>
@endsection