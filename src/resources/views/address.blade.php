@extends('layouts.app')

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
<div class="content--small">
    <div class="common-ttl">住所の変更</div>
    <div class="form">
        <form class="form__inner" action="" method="post">
            @csrf
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