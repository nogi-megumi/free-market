@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
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
    <div class="profile-group">
        <div class="profile-group__user-info">
            <div class="image-container--circle">
                @if (!$userImage)
                <div class="image-container__image image--circle">ユーザーアイコン</div>
                @else
                <img class="image-container__image" src="{{asset('storage/images/' . $userImage)}}" alt="ユーザーアイコン">
                @endif
            </div>
            <p class="profile-group__user-name">{{Auth::user()->name}}</p>
        </div>
        <div class="link-bottun">
            <a class="link-bottun--border" href="/mypage/profile">
                プロフィールを編集
            </a>
        </div>
    </div>
    <div class="tab-group">
        <a class="tab-group__tab {{$tab !=='buy' ?'active' : ''}}" href="/mypage?tab=sell">出品した商品</a>
        <a class="tab-group__tab {{$tab ==='buy' ?'active' : ''}}" href="/mypage?tab=buy">購入した商品</a>
    </div>
    @if (!isset($items))
    @if ($tab==='buy')
    <p class="alart-message">購入した商品商品はありません</p>
    @else
    <p class="alart-message">出品した商品商品はありません</p> @endif
    @else
    <div class="item-index">
        @foreach ($items as $item)
        <div class="item-index__item-group">
            <a href="">
                <div class="image-container--square">
                    <img class="image-container__image" src="{{ asset('storage/images/' . $item->item_image) }}"
                        alt="{{$item->item_name}}">
                </div>
                <p class="item-name">{{$item->item_name}}</p>
            </a>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection