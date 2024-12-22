@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item_index.css')}}">
<script src="{{ asset('/js/tab.js') }}"></script>
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
        <a class="tab-group__tab active" href="/">おすすめ</a>
        <a class="tab-group__tab" href="">マイリスト</a>
        {{-- マイリストはログインユーザーの閲覧可 --}}
    </div>
    <div class="item-index">
        @foreach ($items as $item)
        <div class="item-index__item-group">
            <a href="">
                <div class="image-container--square">
                    <img class="image-container__image"
                        src="{{ asset('storage/images/' . $item->item_image) }}" alt="{{$item->item_name}}">
                </div>
                <p class="item-name">{{$item->item_name}}</p>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection