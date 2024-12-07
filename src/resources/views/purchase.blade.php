@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
<div class="content--large">
    <div class="purchase-input">
        <div class="item-group">
            <div class="image-container--square">
                <img class="image-container__image" src="" alt="商品画像">
            </div>
            <div>
                <p class="item-name">商品名</p>
                <span class="item-price">&yen;47,000</span>
            </div>
        </div>
        <div class="form-group">
            <form class="form" action="">
                @csrf
                <table class="purchase-table">
                    <tr>
                        <th class="purchase-table__th">支払い方法</th>
                    </tr>
                    <tr class="purchase-table__tr">
                        <td class="purchase-table__td">
                            <select class="purchase-table__select" name="payment">
                                <option selected hidden>選択してください</option>
                                <option value="1">コンビニ払い</option>
                                <option value="2">カード支払い</option>
                            </select>
                        </td>
                        <td class="purchase-table__td"></td>
                    </tr>
                    <tr>
                        <th class="purchase-table__th">配送先</th>
                        <td class="purchase-table__td--link">
                            <a class="purchase-table__link" href="">変更する</a>
                        </td>
                    </tr>
                    <tr class="purchase-table__tr">
                        <td class="purchase-table__td">
                            <input class="purchase-table__input" type="text" name="postcode"
                                placeholder="&#12306;XXX-YYYY">
                            <input class="purchase-table__input" type="text" name="address"
                                placeholder="ここには住所と"></input>
                            <input class="purchase-table__input" type="text" name="building"
                                placeholder="建物名が入ります"></input>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="info-group">
        <table class="info-group__table">
            <tr class="info-group__tr">
                <th class="info-group__th">商品代金</th>
                <td class="info-group__td">&yen;47,000</td>
            </tr>
            <tr class="info-group__tr">
                <th class="info-group__th">支払い方法</th>
                <td class="info-group__td">コンビニ払い</td>
            </tr>
        </table>
        <div>
            <button class="form-item__button">購入する</button>
        </div>
    </div>
</div>
@endsection