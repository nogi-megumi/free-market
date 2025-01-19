@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
<script src="{{ asset('/js/select.js') }}"></script>
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
<div class="content--large">
    <form class="form grid" action="{{route('purchase.store',$item)}}" method="POST">
        @csrf
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
                <table class="purchase-table">
                    <tr>
                        <th class="purchase-table__th">支払い方法
                            <span class="error-message">@error('payment')
                                {{$message}}
                                @enderror</span>
                        </th>
                    </tr>
                    <tr class="purchase-table__tr">
                        <td class="purchase-table__td">
                            <select class="purchase-table__select payment" name="payment">
                                <option value="" selected hidden>選択してください</option>
                                <option value="コンビニ払い" @if (old('payment')=='コンビニ払い' )selected @endif>コンビニ払い
                                </option>
                                <option value="カード支払い" @if (old('payment')=='カード支払い' )selected @endif>カード支払い
                                </option>
                            </select>
                        </td>
                        <td class="purchase-table__td"></td>
                    </tr>
                    <tr>
                        <th class="purchase-table__th">配送先
                            <span class="error-message">@error('shipping_address')
                                {{$message}}
                                @enderror</span>
                        </th>
                        <td class="purchase-table__td--link">
                            <a class="purchase-table__link" href="{{route('purchase.edit',$item)}}">変更する</a>
                        </td>
                    </tr>
                    <tr class="purchase-table__tr">
                        <td class="purchase-table__td">
                            <input type="hidden" name="shipping_address"
                                value="{{$address['postcode'].$address[ 'address'] . $address['building']}}">
                            @if ($address['postcode']==null)
                            <p class="purchase-table__input">&#12306;XXX-YYYY</p>
                            <p class="purchase-table__input">ここには住所と建物名が入ります</p>
                            @else
                            <p class="purchase-table__input">&#12306;{{$address['postcode']}}</p>
                            <p class="purchase-table__input">{{$address['address']}}</p>
                            <p class="purchase-table__input">{{$address['building']}}</p>
                            @endif
                        </td>
                    </tr>
                </table>
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
                <button class="form-item__button" type="submit">購入する</button>
            </div>
        </div>
    </form>
</div>
@endsection