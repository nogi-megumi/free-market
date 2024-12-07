@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
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
            @if (auth::check())
            <li class="header-nav__list">
                <a class="header-nav__list-item" href="/logout">
                    ログアウト
                </a>
            </li>
            @else
            <li class="header-nav__list">
                <a class="header-nav__list-item" href="/login">ログイン</a>
            </li>
            @endif

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
    <div class="tab-group">
        <a class="tab-group__tab" href="">おすすめ</a>
        <a class="tab-group__tab" href="">マイリスト</a>
        {{-- マイリストはログインユーザーの閲覧可 --}}
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
    </div>

</div>
@endsection