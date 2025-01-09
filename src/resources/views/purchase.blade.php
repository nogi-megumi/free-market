@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
<script src="{{ asset('/js/select.js') }}"></script>
@endsection

@section('header-item')
<div class="header-search">
    <form class="header-search-form" action="/" method="POST" action="">
        @csrf
        <input class="header-search-form__input" name="keyword" value="{{ request('keyword') }}" type="text"
            placeholder="何をお探しですか？" type="text" placeholder="何をお探しですか？">
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
    <div class="purchase-input">
        <div class="item-group">
            <div class="image-container--square">
                <img class="image-container__image" src="{{asset('storage/images/' . $item->item_image)}}"
                    alt="{{$item->item_name}}">
            </div>
            <div>
                <p class="item-name">{{$item->item_name}}</p>
                <span class="item-price">&yen;{{number_format($item->price)}}</span>
            </div>
        </div>
        <div class="form-group">
            <form class="form" action="{{route('purchase.store',$item)}}" method="POST">
                {{-- formタグの位置を変更するかも　もっと上かも --}}
                @csrf
                <table class="purchase-table">
                    <tr>
                        <th class="purchase-table__th">支払い方法</th>
                    </tr>
                    <tr class="purchase-table__tr">
                        <td class="purchase-table__td">
                            <select class="purchase-table__select payment" name="payment">
                                <option selected hidden>選択してください</option>
                                <option value="コンビニ払い">コンビニ払い</option>
                                <option value="カード支払い">カード支払い</option>
                            </select>
                        </td>
                        <td class="purchase-table__td"></td>
                    </tr>
                    <tr>
                        <th class="purchase-table__th">配送先</th>
                        <td class="purchase-table__td--link">
                            <a class="purchase-table__link" href="{{route('purchase.edit',$item)}}">変更する</a>
                        </td>
                    </tr>
                    <tr class="purchase-table__tr">
                        <td class="purchase-table__td">
                            <input class="purchase-table__input" type="text" name="postcode"
                                value="{{$address->postcode ?? ''}}" placeholder="&#12306;XXX-YYYY" readonly>
                            <input class="purchase-table__input" type="text" name="address"
                                value="{{$address->address ?? ''}}" placeholder="ここには住所と" readonly>
                            <input class="purchase-table__input" type="text" name="building"
                                value="{{$address->building ?? ''}}" placeholder="建物名が入ります" readonly>
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
                <td class="info-group__td">&yen;{{number_format($item->price)}}</td>
            </tr>
            <tr class="info-group__tr">
                <th class="info-group__th">支払い方法</th>
                <td class="info-group__td payment-result"></td>
            </tr>
        </table>
        <div>
            <button class="form-item__button">購入する</button>
        </div>
    </div>
</div>
@endsection