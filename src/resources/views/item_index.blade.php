@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
@endsection

@section('header-item')

@include('layouts.search-form')
<div class="header-nav">
    <nav>
        <ul class="header-nav__group">
            @if (Auth::check())
            <li class="header-nav__list">
                <form class="header-nav__list-item" action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="header-nav__list-item">ログアウト</button>
                </form>
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
        @if (!isset($keyword))
        <a class="tab-group__tab {{$tab !=='mylist' ?'active' : ''}}" href="/">おすすめ</a>
        <a class="tab-group__tab {{$tab ==='mylist' ?'active' : ''}}" href="/?tab=mylist">マイリスト</a>
        @else
        <a class="tab-group__tab {{request('tab', 'recommend') !=='mylist' ?'active' : ''}}"
            href="/?tab=recommend&keyword={{ request('keyword') }}">おすすめ</a>
        <a class="tab-group__tab {{request('tab') ==='mylist' ?'active' : ''}}"
            href="/?tab=mylist&keyword={{request('keyword')}}">マイリスト</a>
        @endif
    </div>
    @if (isset($items))
    <div class="item-index">
        @foreach ($items as $item)
        <div class="item-index__item-group">
            <a href="{{ route('item.show', $item) }}">
                <div class="image-container--square">
                    @if ($item->status==='売却済')
                    <span class="sold">Sold</span>
                    @endif
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