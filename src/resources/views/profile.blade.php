@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
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
            @include('layouts.navi-list')
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="content--large">
    <div class="profile-group">
        <div class="profile-group__user-info">
            @if (!$userImage)
            <div class="image-container no-image circle"></div>
            @else
            <div class="image-container circle">
                <img class="image-container__image" src="{{asset('storage/images/' . $userImage)}}" alt="ユーザーアイコン">
            </div>
            @endif
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
    @if (isset($items))
    <div class="item-index">
        @foreach ($items as $item)
        <div class="item-index__item-group">
            <a href="{{route('item.show',$item)}}">
                <div class="image-container--square">
                    <img class="image-container__item-image" src="{{ asset('storage/images/' . $item->item_image) }}"
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