@extends('layouts.app')

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
            @include('layouts.navi-list')
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="content--small">
    <div class="common-ttl">住所の変更</div>
    <div class="form">
        <form class="form__inner" action="{{route('purchase.update',$item)}}" method="post">
            @csrf
            <div class="form-item">
                <label class="form-item__label">郵便番号</label>
                <input class="form-item__input" type="text" name="postcode"
                    value="{{ old('postcode',$address->postcode ?? '')}}">
            </div>
            <p class="error-message">@error('postcode')
                {{$message}}
                @enderror</p>
            <div class="form-item">
                <label class="form-item__label">住所</label>
                <input class="form-item__input" type="text" name="address"
                    value="{{ old('address',$address->address ?? '')}}">
            </div>
            <p class="error-message">@error('address')
                {{$message}}
                @enderror</p>
            <div class="form-item">
                <label class="form-item__label">建物名</label>
                <input class="form-item__input" type="text" name="building"
                    value="{{ old('building',$address->building ?? '')}}">
            </div>
            <p class="error-message">@error('building')
                {{$message}}
                @enderror</p>
            <div class="form-item">
                <button class="form-item__button" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection