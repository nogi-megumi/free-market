@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="css/profile_edit.css">
<link rel="stylesheet" href="css/exhibition.css">
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
                <a class="header-nav__list-item" href="">マイページ</a>
            </li>
            <li class="header-nav__list">
                <a class="header-nav__list-item link--exhibition" href="">出品</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="content--small">
    <div class="common-ttl">商品の出品</div>
    <div class="form">
        <form class="form__inner" action="/" method="post">
            @csrf
            <div class="form-item">
                <p class="form-item__label">商品画像</p>
                <div class="image-container--transparent">
                    <label class="link-bottun--border" for="item_image">画像を選択する
                        <input class="input-image" type="text" name="item_image">
                    </label>
                </div>
            </div>
            <h3 class="exhibition-ttl">商品の詳細</h3>
            <div class="form-item">
                <p class="form-item__label">カテゴリー</p>
                <div class="category-group">
                    <label class="form-item__category-label" for="fashion">
                        <input id="fashion" class="form-item__checkbox" type="checkbox" name="category"
                            value="ファッション"><span>ファッション</span>
                    </label>
                    <label class="form-item__category-label" for="interior">
                        <input id="interior" class="form-item__checkbox" type="checkbox" name="category"
                            value="インテリア"><span>インテリア</span>
                    </label>
                    <label class="form-item__category-label" for="mens">
                        <input id="mens" class="form-item__checkbox" type="checkbox" name="category"
                            value="メンズ"><span>メンズ</span>
                    </label>
                    <label class="form-item__category-label" for="ladies">
                        <input id="ladies" class="form-item__checkbox" type="checkbox" name="category"
                            value="レディース"><span>レディース</span>
                    </label>
                    <label class="form-item__category-label" for="game">
                        <input id="game" class="form-item__checkbox" type="checkbox" name="category"
                            value="ゲーム"><span>ゲーム</span>
                    </label>
                </div>
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">商品の状態</label>
                <select class="form-item__select" name="condition">
                    <option value="" selected hidden>選択してください</option>
                    <option value="1">良好</option>
                    <option value="2">目立った傷や汚れなし</option>
                    <option value="3">やや傷や汚れあり</option>
                    <option value="4">状態が悪い</option>
                </select>
            </div>
            <h3 class="exhibition-ttl">商品名と説明</h3>
            <div class="form-item">
                <label class="form-item__label" for="">商品名</label>
                <input class="form-item__input" type="text" name="item_name">
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">ブランド名</label>
                <input class="form-item__input" type="text" name="brand">
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">商品の説明</label>
                <textarea class="form-item__detail" name="detail" cols="" rows="5"></textarea>
            </div>
            <div class="form-item">
                <label class="form-item__label" for="">販売価格</label>
                <input class="form-item__input" type="number" name="price" placeholder="&yen;">
            </div>
        </form>
        <div class="form-item">
            <button class="form-item__button">出品する</button>
        </div>
    </div>
</div>
@endsection